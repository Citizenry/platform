<?php

/**
 * StreetSignal Platform Factory for Repositories
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Factory;

class RepositoryFactory
{
    // Array of repositories, mapped by resource:
    //
    //     $map = [
    //         'widgets' => $di->lazyNew('Namespace\To\WidgetRepository'),
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
     * Gets a repository from the map by resource.
     * @param  String $resource
     * @return StreetSignal\Repository
     */
    public function get($resource)
    {
        $factory = $this->map[$resource];
        return $factory();
    }
}
