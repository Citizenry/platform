<?php

/**
 * StreetSignal Export Batch Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2018 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Repository;

use StreetSignal\Core\Entity\ExportBatch;
use StreetSignal\Contracts\Repository\Entity\ExportBatchRepository as ExportBatchRepositoryContract;
use StreetSignal\Contracts\Search;

class ExportBatchRepository extends EloquentRepository implements ExportBatchRepositoryContract
{
    /**
     * Get the entity for this repository.
     * @param  Array  $data
     * @return \StreetSignal\Contracts\Entity
     */
    public function getEntity(array $data = null)
    {
        return new ExportBatch($data);
    }

    /**
     * Get the table name for this repository.
     * @return String
     */
    protected function getTable()
    {
        return 'export_batches';
    }

    /**
     * Get all batches for job id
     * @param  int $jobId
     * @param  string $status
     * @return \Illuminate\Support\Collection
     */
    public function getByJobId($jobId, $status = ExportBatch::STATUS_COMPLETED)
    {
        $results = $this
            ->selectQuery([
                'export_job_id' => $jobId,
                'status' => $status
            ])
            ->get();

        return $this->getCollection($results);
    }

    public function getSearchFields()
    {
    }

    public function getSearchTotal()
    {
    }

    public function getSearchResults()
    {
    }
    public function setSearchParams(Search $search)
    {
    }
}
