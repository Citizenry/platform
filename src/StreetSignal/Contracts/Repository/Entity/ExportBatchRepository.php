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

use StreetSignal\Contracts\Repository\CreateRepository;
use StreetSignal\Contracts\Repository\SearchRepository;
use StreetSignal\Contracts\Repository\UpdateRepository;

interface ExportBatchRepository extends
    CreateRepository,
    UpdateRepository,
    SearchRepository
{
    /**
     * Get all batches for job id
     *
     * @param  int $jobId
     * @param  string $status
     *
     * @return \Illuminate\Support\Collection
     */
    public function getByJobId($jobId, $status);
}
