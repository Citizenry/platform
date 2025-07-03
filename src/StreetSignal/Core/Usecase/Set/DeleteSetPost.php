<?php

/**
 * Remove post from set Use Case
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\Set;

use StreetSignal\Core\Usecase\DeleteUsecase;

class DeleteSetPost extends DeleteUsecase
{
    use SetRepositoryTrait,
        GetSetEntityTrait,
        AuthorizeSet;

    // Usecase
    public function interact()
    {
        // Fetch the post, using provided identifiers...
        $post = $this->getEntity();

        // ... fetch the set entity
        $set = $this->getSetEntity();

        // ... and that the set can be edited by the current user
        $this->verifySetUpdateAuth($set);

        // ... remove the post from the set
        $this->setRepo->deleteSetPost($set->id, $post->id);

        // ... and return the formatted entity
        return $this->formatter->__invoke($post);
    }
}
