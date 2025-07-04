<?php

/**
 * StreetSignal Platform Factory for Authorizers
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Factory;

class AuthorizerFactory
{
    // Array of authorizers, mapped by resource:
    //
    //     $map = [
    //         'widgets' => $di->lazyNew('Namespace\To\WidgetAuthorizer'),
    //         ...
    //     ]
    //
    // Resource names correspond with entity types.
    protected $map = [];

    /**
     * @param  Array $map
     */
    public function __construct(array $map)
    {
        $this->map = $map;
    }

    /**
     * Gets an authorizer from the map by resource.
     * @param  string $resource
     * @return \StreetSignal\Contracts\Authorizer
     */
    public function get($resource)
    {
        $factory = $this->map[$resource];
        return $factory();
    }
}
