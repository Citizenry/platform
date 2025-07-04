<?php

/**
 * Repository for Post Values
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Usecase;

use StreetSignal\Contracts\Entity;

interface ValuesForPostRepository
{
    /**
     * @param  int $post_id
     * @param  array $include_attributes
     * @param  array $exclude_stages
     * @param  boolean $excludePrivateValues
     *
     * @return Entity[] $postvalues
     */
    public function getAllForPost(
        $post_id,
        array $include_attributes = [],
        array $exclude_stages = [],
        $excludePrivateValues = true
    );

    /**
     * @param  int $post_id
     *
     * @return Entity[] $postvalues
     */
    public function deleteAllForPost($post_id);
}
