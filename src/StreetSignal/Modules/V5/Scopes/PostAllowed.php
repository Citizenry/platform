<?php
/**
 * StreetSignal Acl
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2020 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 *
 */


namespace StreetSignal\Modules\V5\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PostAllowed implements Scope
{

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $authorizer = service('authorizer.post');
        // if there's no user the guards will kick them off already, but if there
        // is one we need to check the authorizer to ensure we don't let
        // users without admin perms create forms etc
        // this is an unfortunate problem with using an old version of lumen
        // that doesn't let me do guest user checks without adding more risk.
        $user = $authorizer->getUser();

        $postPermissions = new \StreetSignal\Core\Tool\Permissions\PostPermissions();
        $postPermissions->setAcl($authorizer->acl);
        $builder->where('posts.type', '=', 'report');
        /**
         * With scopes and the $builder, we check for basic permissions right on our initial
         * queries rather than process them after the fact
         */
        if (!$postPermissions->canUserViewUnpublishedPosts(
            $user
        )) {
            $builder->where(function ($query) use ($user) {
                $query->where('posts.status', '=', 'published');
                if ($user->getId()) {
                    $query->orWhere('posts.user_id', '=', $user->getId());
                }
                return $query;
            });
        }
    }
}
