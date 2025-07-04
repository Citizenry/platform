<?php

/**
 * Read post in Set Use Case
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\Set;

use StreetSignal\Core\Usecase\Post\ReadPost;

class ReadSetPost extends ReadPost
{
    use SetRepositoryTrait,
        VerifySetExistsTrait;

    protected function getEntity()
    {
        $this->verifyPostRepo($this->repo);

        $id     = $this->getIdentifier('id');
        $set_id = $this->getIdentifier('set_id');

        $entity = $this->repo->getPostInSet($id, $set_id);

        $this->verifyEntityLoaded($entity, compact('id'));

        return $entity;
    }
}
