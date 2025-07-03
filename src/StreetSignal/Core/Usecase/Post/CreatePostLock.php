<?php

/**
 * StreetSignal Platform Create Post Lock Use Case
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2017 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\Post;

use StreetSignal\Core\Usecase\UpdateUsecase;
use StreetSignal\Core\Usecase\Post\Concerns\PostLock;

class CreatePostLock extends UpdateUsecase
{
    use PostLock;

    // Usecase
    public function interact()
    {
        // Fetch a default entity and apply the payload...
        $post = $this->getPostEntity();

        // ... verify that the entity can be created by the current user
        $this->verifyLockAuth($post);

        $id = $this->repo->getLock($post);

        $lock = $this->getLockEntity($id);

        return $this->formatter->__invoke($lock);
    }
}
