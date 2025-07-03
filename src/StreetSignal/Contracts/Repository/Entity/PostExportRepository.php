<?php

/**
 * StreetSignal Platform Post Export Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2017 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Entity;

interface PostExportRepository
{

    /**
     * Get Column Names for given Post Data
     * @param  Post Data array $data
     * @return Array
     */
    public function retrieveMetaData($data, $attributes);

    public function retrieveCompletedStageNames($stage_ids);
}
