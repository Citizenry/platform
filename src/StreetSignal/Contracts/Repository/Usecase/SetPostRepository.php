<?php

/**
 * StreetSignal Platform Set Post Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Usecase;

use StreetSignal\Contracts\Entity;

interface SetPostRepository
{
    /**
     * @param  int    $post_id
     * @param  int    $set_id
     *
     * @return Entity $post
     */
    public function getPostInSet($post_id, $set_id);
}
