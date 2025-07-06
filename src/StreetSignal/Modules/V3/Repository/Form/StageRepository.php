<?php

/**
 * StreetSignal Form Stage Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Repository\Form;

use Ohanzee\DB;
use Ohanzee\Database;
use StreetSignal\Core\Tool\SearchData;
use StreetSignal\Core\Entity\FormStage;
use StreetSignal\Contracts\Repository\Entity\FormStageRepository as FormStageRepositoryContract;
use StreetSignal\Contracts\Repository\Entity\FormRepository as FormRepositoryContract;
use StreetSignal\Core\Concerns\UserContext;
use StreetSignal\Core\Tool\Permissions\InteractsWithFormPermissions;
use StreetSignal\Modules\V3\Repository\BaseRepository;
use StreetSignal\Contracts\Search;

class StageRepository extends BaseRepository implements
    FormStageRepositoryContract
{
    use UserContext;

    use InteractsWithFormPermissions;

    protected $form_id;
    protected $form_repo;

        /**
         * Construct
         * @param Database                              $db
         * @param FormRepository                       $form_repo
         */
    public function __construct(
        \StreetSignal\Core\Tool\OhanzeeResolver $resolver,
        FormRepositoryContract $form_repo
    ) {

        parent::__construct($resolver);

        $this->form_repo = $form_repo;
    }

    // OhanzeeRepository
    protected function getTable()
    {
        return 'form_stages';
    }

    // Override selectQuery to fetch attribute 'key' too
    protected function selectQuery(array $where = [], $form_id = null, $post_status = null)
    {
        $query = parent::selectQuery($where);

        $user = $this->getUser();
        if (!$this->formPermissions->canUserEditForm($user, $form_id)) {
            $query->where('show_when_published', '=', "1");

            if ($post_status !== 'published') {
                $query->where('task_is_internal_only', '=', "0");
            }
        }

        return $query;
    }

    // CreateRepository
    // ReadRepository
    public function getEntity(array $data = null)
    {
        return new FormStage($data);
    }

    // SearchRepository
    public function getSearchFields()
    {
        return ['form_id', 'label', 'postStatus'];
    }

    // Override SearchRepository
    public function setSearchParams(Search $search)
    {
        $form_id = null;
        if ($search->form_id) {
            $form_id = $search->form_id;
        }

        $post_status = $search->postStatus ? $search->postStatus : '';

        $this->search_query = $this->selectQuery([], $form_id, $post_status);

        $sorting = $search->getSorting();

        if (!empty($sorting['orderby'])) {
            $this->search_query->orderBy(
                $this->getTable() . '.' . $sorting['orderby'],
                isset($sorting['order']) ? $sorting['order'] : 'ASC'
            );
        }

        if (!empty($sorting['offset'])) {
            $this->search_query->offset($sorting['offset']);
        }

        if (!empty($sorting['limit'])) {
            $this->search_query->limit($sorting['limit']);
        }

        // apply the unique conditions of the search
        $this->setSearchConditions($search);
    }

    // OhanzeeRepository
    protected function setSearchConditions(SearchData $search)
    {
        $query = $this->search_query;

        if ($search->form_id) {
            $query->where('form_id', '=', $search->form_id);
        }

        if ($search->q) {
            // Form group text searching
            $query->where('label', 'LIKE', "%{$search->q}%");
        }
    }

    public function getFormByStageId($id)
    {
        $result = $this->db()->table('form_stages')
                ->select('form_id')
                ->where('id', '=', $id)
                ->first();

        return $result ? $result->form_id : false;
    }

    // FormStageRepository
    public function getByForm($form_id)
    {
        $query = $this->selectQuery(['form_id' => $form_id], $form_id);
        $results = $query->get();

        return $this->getCollection($results->toArray());
    }

    /**
        * Retrieve Hidden Stage IDs for a given form
        * if no form is found return false
        * @param  $form_id
        * @return Array
        */
    public function getHiddenStageIds($form_id, $post_status = null)
    {
            $stages = [];

            $query = $this->db()->table('form_stages')
                    ->select('id')
                    ->where('form_id', '=', $form_id);

        if ($post_status === 'published') {
            $query->where('show_when_published', '=', 0);
        } else {
            $query->where(function($q) {
                $q->where('show_when_published', '=', 0)
                  ->orWhere('task_is_internal_only', '=', 1);
            });
        }

            $results = $query->get();

        foreach ($results as $stage) {
            array_push($stages, $stage->id);
        }

            return $stages;
    }

    // FormStageRepository</search>

    // FormStageRepository
    public function existsInForm($id, $form_id)
    {
        return (bool) $this->selectCount(compact('id', 'form_id'));
    }

    // FormStageRepository
    public function getRequired($form_id)
    {
        $query = $this->selectQuery([
                'form_stages.form_id'  => $form_id,
                'form_stages.required' => true
            ], $form_id)
            ->select('form_stages.*');

        $results = $query->get();

        return $this->getCollection($results->toArray());
    }

    // FormStageRepository
    public function getPostStage($form_id)
    {
        return $this->getEntity($this->selectOne([
                'form_stages.form_id'  => $form_id,
                'form_stages.type' => 'post'
            ]));
    }
}
