<?php

/**
 * StreetSignal Platform Admin Update Tag Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Usecase;

interface UpdateTagRepository
{
    /**
     * @param  string $slug
     *
     * @return boolean
     */
    public function isSlugAvailable($slug);
}
