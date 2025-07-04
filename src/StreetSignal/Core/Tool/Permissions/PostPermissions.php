<?php

/**
 * Post Permissions
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Tool\Permissions;

use StreetSignal\Contracts\Entity;
use StreetSignal\Contracts\Permission;
use StreetSignal\Core\Concerns\AdminAccess;
use StreetSignal\Core\Concerns\Acl as AccessControlList;
use StreetSignal\Contracts\Repository\Entity\FormRepository;

class PostPermissions
{
    use AccessControlList;
    use AdminAccess;

    /**
     * Does the current user have permission to see if a post if locked?
     *
     * @param \StreetSignal\Contracts\Entity $user
     * @param \StreetSignal\Contracts\Entity $post
     * @return boolean
     */
    public function canUserSeePostLock(Entity $user, Entity $post)
    {
        // At present only logged in users with Manage Post Permission can see that a Post is locked
        // @todo if we're checking manage posts, check that - don't check if a user can edit a form!?
        //       More accurately I think if they can edit a post, the should be able to see locks
        return $this->acl->hasPermission($user, Permission::MANAGE_POSTS);
    }

    /**
     * Does the user have permission to view this posts author
     *
     * @param  \StreetSignal\Contracts\Entity $user
     * @param  \StreetSignal\Contracts\Entity $post
     * @param  \StreetSignal\Contracts\Repository\Entity\FormRepository $form_repo
     * @return boolean
     */
    public function canUserSeeAuthor(Entity $user, Entity $post, FormRepository $form_repo)
    {
        // If the user has manage post permission
        // @todo delegate to authorizer
        if ($this->acl->hasPermission($user, Permission::MANAGE_POSTS)) {
            // If so, they can also see post authors
            return true;
        }

        // If the post is structured
        if ($post->form_id) {
            // @todo inject form repo via constructor or take form as parameter
            // ... if not, check if the form has author set as hidden or public
            return !$form_repo->isTypeHidden($post->form_id, 'hide_author');
        }

        // Default to scrubbing author info for non-admins on unstructured posts
        return false;
    }

    /**
     * Does the user have permission to view this posts exact time
     *
     * @param  \StreetSignal\Contracts\Entity $user
     * @param  \StreetSignal\Contracts\Entity $post
     * @param  \StreetSignal\Contracts\Repository\Entity\FormRepository $form_repo
     * @return boolean
     */
    public function canUserSeeTime(Entity $user, Entity $post, FormRepository $form_repo)
    {
        // If the user has manage post permission
        // @todo delegate to authorizer
        if ($this->acl->hasPermission($user, Permission::MANAGE_POSTS)) {
            // If so, they can also see post dates
            return true;
        }

        // If the post is structured
        if ($post->form_id) {
            // @todo inject form repo via constructor or take form as parameter
            // ... if not, check if the form has author set as hidden or public
            return !$form_repo->isTypeHidden($post->form_id, 'hide_time');
        }

        // Default to scrubbing info for non-admins on unstructured posts
        return false;
    }

    /**
     * Does the user have permission to view this posts exact location
     *
     * @param  \StreetSignal\Contracts\Entity $user
     * @param  \StreetSignal\Contracts\Entity $post
     * @param  \StreetSignal\Contracts\Repository\Entity\FormRepository $form_repo
     * @return boolean
     */
    public function canUserSeeLocation(Entity $user, Entity $post, FormRepository $form_repo)
    {
        // If the user has manage post permission
        // @todo delegate to authorizer
        if ($this->acl->hasPermission($user, Permission::MANAGE_POSTS)) {
            // If so, they can also see post location
            return true;
        }

        // If the post is structured
        if ($post->form_id) {
            // @todo inject form repo via constructor or take form as parameter
            // ... if not, check if the form has location set as hidden or public
            return !$form_repo->isTypeHidden($post->form_id, 'hide_location');
        }

        // Default to scrubbing info for non-admins on unstructured posts
        return false;
    }

    /**
     * Test whether the user can manage posts
     *
     * @param  \StreetSignal\Contracts\Entity $user
     * @return boolean
     */
    public function canUserManagePosts(Entity $user)
    {
        // Delegate to post authorizer
        return $this->acl->hasPermission($user, Permission::MANAGE_POSTS);
    }

    /**
     * Test whether the post instance requires value restriction
     *
     * @param  \StreetSignal\Contracts\Entity $user
     * @return Boolean
     */
    public function canUserReadPrivateValues(Entity $user)
    {
        // Delegate to post authorizer
        return $this->acl->hasPermission($user, Permission::MANAGE_POSTS);
    }

    /**
     * Does user have permission to see unpublished (draft/archived) posts
     *
     * @param  \StreetSignal\Contracts\Entity   $user
     * @return boolean
     */
    public function canUserViewUnpublishedPosts(Entity $user)
    {
        return $user && $this->acl->hasPermission($user, Permission::MANAGE_POSTS);
    }
}
