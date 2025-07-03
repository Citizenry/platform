<?php

/**
 * StreetSignal Platform Admin Read Tag Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Usecase;

interface ReadTagRepository
{
    /**
     * @param  int $id
     */
    public function get($id);
}
