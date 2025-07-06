<?php

/**
 * StreetSignal Form Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Repository;

use StreetSignal\Core\Tool\SearchData;
use StreetSignal\Core\Entity\Form;
use StreetSignal\Core\Concerns\Event;
use Illuminate\Support\Collection;
use StreetSignal\Contracts\Entity;
use StreetSignal\Modules\V3\Repository\Concerns\FormsTags;
use StreetSignal\Contracts\Repository\Entity\FormRepository as FormRepositoryContract;

class FormRepository extends BaseRepository implements
    FormRepositoryContract
{
    use FormsTags;

    // Use Event trait to trigger events
    use Event;

    use Concerns\UsesBulkAutoIncrement;

    // OhanzeeRepository
    protected function getTable()
    {
        return 'forms';
    }

    // CreateRepository
    // ReadRepository
    public function getEntity(array $data = null)
    {
        if (isset($data["id"])) {
            $can_create = $this->getRolesThatCanCreatePosts($data['id']);
            $data = $data + [
                'can_create' => $can_create['roles'],
                'tags' => $this->getTagsForForm($data['id'])
            ];
        }
        return new Form($data);
    }

    // SearchRepository
    public function getSearchFields()
    {
        return ['parent', 'q' /* LIKE name */];
    }

    // OhanzeeRepository
    protected function setSearchConditions(SearchData $search)
    {
        $query = $this->search_query;
        if ($search->parent) {
            $query->where('parent_id', '=', $search->parent);
        }

        if ($search->q) {
            // Form text searching
            $query->where('name', 'LIKE', "%{$search->q}%");
        }
    }

    // CreateRepository
    public function create(Entity $entity)
    {
        $id = parent::create($entity->setState(['created' => time()]));
        // todo ensure default group is created
        return $id;
    }

    public function createMany(Collection $collection) : array
    {
        $this->checkAutoIncMode();

        $values = $collection->map(function ($entity) {
            $data = $entity->asArray();

            unset($data['can_create'], $data['tags']);
            $data['created'] = time();

            return $data;
        })->all();

        $insertId = $this->db()->table($this->getTable())->insertGetId($values[0]);
        
        // For multiple inserts, we need to handle them individually to get proper IDs
        $ids = [$insertId];
        for ($i = 1; $i < count($values); $i++) {
            $ids[] = $this->db()->table($this->getTable())->insertGetId($values[$i]);
        }

        return $ids;
    }

    // UpdateRepository
    public function update(Entity $entity)
    {
        // If orignal Form update Intercom if Name changed
        if ($entity->id === 1) {
            foreach ($entity->getChanged() as $key => $val) {
                $key === 'name' ? $this->emit($this->event, ['primary_survey_name' => $val]) : null;
            }
        }
        $form = $entity->getChanged();
        $form['updated'] = time();
        // removing tags from form before saving
        unset($form['tags']);
        // Finally save the form
        $id = $this->executeUpdate(['id'=>$entity->id], $form);

        return $id;
    }

    /**
     * Get total count of entities
     * @param  Array $where
     * @return int
     */
    public function getTotalCount(array $where = [])
    {
        return $this->selectCount($where);
    }

    /**
      * Get value of Form property type
      * if no form is found return false
      * @param  $form_id
      * @param $type, form property to check
      * @return Boolean
      */
    public function isTypeHidden($form_id, $type)
    {
        $result = $this->db()->table('forms')
            ->select($type)
            ->where('id', '=', $form_id)
            ->first();

        return $result ? $result->$type : false;
    }

    /**
     * Get `everyone_can_create` and list of roles that have access to post to the form
     * @param  $form_id
     * @return Array
     */
    public function getRolesThatCanCreatePosts($form_id)
    {
        $results = $this->db()->table('forms')
            ->select('forms.everyone_can_create', 'roles.name')
            ->distinct()
            ->leftJoin('form_roles', 'forms.id', '=', 'form_roles.form_id')
            ->leftJoin('roles', 'roles.id', '=', 'form_roles.role_id')
            ->where('forms.id', '=', $form_id)
            ->get()
            ->toArray();

        $everyone_can_create = (count($results) == 0 ? 1 : $results[0]->everyone_can_create);

        $roles = [];

        foreach ($results as $role) {
            if (!is_null($role->name)) {
                $roles[] = $role->name;
            }
        }

        return [
            'everyone_can_create' => $everyone_can_create,
            'roles' => $roles,
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function getAllFormStagesAttributes(array $form_ids = []): Collection
    {
        $query = $this->db()->table('forms')
            ->select(
                'forms.id as form_id',
                'form_stages.id as form_stage_id',
                'form_attributes.*'
            )
            ->join('form_stages', 'forms.id', '=', 'form_stages.form_id')
            ->join('form_attributes', 'form_stages.id', '=', 'form_attributes.form_stage_id')
            ->orderBy('form_stages.id')
            ->orderBy('form_stages.priority')
            ->orderBy('form_attributes.priority');

        if (!empty($form_ids)) {
            $query->whereIn('forms.id', $form_ids);
        }

        $results = $query->get()->toArray();

        return new Collection($results);
    }
}
