<?php

/**
 * StreetSignal Platform Admin Delete Tag Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Usecase;

interface DeleteTagRepository
{
    // TagRepository
    public function get($id);

    /**
     * @param  Integer $id
     */
    public function deleteTag($id);
}
