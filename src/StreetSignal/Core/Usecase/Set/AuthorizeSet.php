<?php

/**
 * StreetSignal Platform Get Set for Set/Post Usecase
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\Set;

use StreetSignal\Contracts\Entity;
use StreetSignal\Contracts\Authorizer;

use StreetSignal\Core\Exception\AuthorizerException;

trait AuthorizeSet
{
    /**
     * @var Authorizer
     */
    protected $setAuth;

    /**
     * @param  Authorizer $auth
     * @return void
     */
    public function setSetAuthorizer(Authorizer $auth)
    {
        $this->setAuth = $auth;
        return $this;
    }

    /**
     * Verifies the current user is allowed $privilege on $entity
     *
     * @param  Entity  $entity
     * @param  string  $privilege
     *
     * @return void
     *
     * @throws AuthorizerException
     */
    protected function verifySetAuth(Entity $entity, $privilege)
    {
        if (!$this->setAuth->isAllowed($entity, $privilege)) {
            throw new AuthorizerException(sprintf(
                'User %d is not allowed to %s resource %s #%d',
                $this->auth->getUserId(),
                $privilege,
                $entity->getResource(),
                $entity->getId()
            ));
        }
    }

    /**
     * Verifies the current user is allowed update access on $entity
     *
     * @param  Entity  $entity
     *
     * @return void
     *
     * @throws AuthorizerException
     */
    protected function verifySetUpdateAuth(Entity $entity)
    {
        $this->verifySetAuth($entity, 'update');
    }
}
