<?php

/**
 * Repository for export jobs
 *
 * @author    StreetSignal Team <team@streetsignal.com>
 * @package   StreetSignal\Platform
 * @copyright 2022 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license   https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Entity;

use StreetSignal\Contracts\EntityExists;
use StreetSignal\Contracts\Repository\ReadRepository;
use StreetSignal\Contracts\Repository\CreateRepository;
use StreetSignal\Contracts\Repository\UpdateRepository;

interface ExportJobRepository extends
    EntityExists,
    CreateRepository,
    ReadRepository,
    UpdateRepository
{
    /**
     * Get new webhooks
     *
     * @param  int $limit
     * @return array
     */
    public function getJobs($limit);

    /**
     * Check if job batches are finished?
     *
     * @param  Int  $jobId
     * @return boolean
     */
    public function areBatchesFinished($jobId);

    /**
     * @param  int $job_id
     * @return int
     */
    public function getPostCount($job_id);
}
