<?php

/**
 * StreetSignal Webhook Job Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Repository\Webhook;

use StreetSignal\Core\Tool\SearchData;
use StreetSignal\Contracts\Entity;
use StreetSignal\Core\Entity\WebhookJob;
use StreetSignal\Modules\V3\Repository\OhanzeeRepository;
use StreetSignal\Contracts\Repository\Entity\WebhookJobRepository as WebhookJobRepositoryContract;

class JobRepository extends OhanzeeRepository implements WebhookJobRepositoryContract
{
    protected function getTable()
    {
        return 'webhook_job';
    }

    // OhanzeeRepository
    public function setSearchConditions(SearchData $search)
    {
        $query = $this->search_query;

        foreach ([
            'post',
            'webhook',
        ] as $fk) {
            if ($search->$fk) {
                $query->where("webhook_job.{$fk}_id", '=', $search->$fk);
            }
        }
    }

    public function getEntity(array $data = null)
    {
        return new WebhookJob($data);
    }

    // CreateRepository
    public function create(Entity $entity)
    {
        $state = [
            'created' => time(),
        ];

        return parent::create($entity->setState($state));
    }

    // WebhookJobRepository
    public function getJobs($limit)
    {
        $query = $this->selectQuery()
                      ->limit($limit)
                      ->order_by('created', 'ASC');

        $results = $query->execute($this->db());

        return $this->getCollection($results->as_array());
    }

    public function getSearchFields()
    {
        return [
            'post',
            'webhook'
        ];
    }
}
