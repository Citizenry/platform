<?php

/**
 * Repository for Set
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2022 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Entity;

use StreetSignal\Contracts\EntityGet;
use StreetSignal\Contracts\EntityExists;
use StreetSignal\Contracts\Repository\SearchRepository;

interface SetRepository extends
    EntityGet,
    EntityExists,
    SearchRepository
{
    public function setSavedSearch($saveSearch);

    /**
     * @param  Int $set_id
     * @param  Int $post_id
     */
    public function deleteSetPost($set_id, $post_id);

    /**
     * @param Int $set_id
     * @param Int $post_id
     * @return Boolean
     */
    public function setPostExists($set_id, $post_id);

    /**
     * @param Int $set_id
     * @param Int $post_id
     */
    public function addPostToSet($set_id, $post_id);
}
