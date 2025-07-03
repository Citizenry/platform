<?php

/**
 * StreetSignal Saved Search
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Entity;

class SavedSearch extends Set
{

    const DEFAULT_VIEW = 'list';
    const DEFAULT_FEATURED = 0;

    protected $filter;
    protected $search;


    // DataTransformer
    protected function getDefinition()
    {
        return parent::getDefinition() + [
            'filter' => '*json',
            'search' => 'boolean'

        ];
    }

    // Entity
    public function getResource()
    {
        return 'savedsearches';
    }

    public static function buildEntity(array $input, $action = "create", array $old_Values = null): Set
    {
        if ($action === "update") {
            $filter = isset($input["filter"]) ? $input["filter"] : $old_Values['filter'];
        } else {
            $filter = isset($input["filter"]) ? $input["filter"] : null;
        }
        $entity = Set::buildEntity($input, $action, $old_Values);
        return new SavedSearch(array_merge($entity->asArray(), ["search" => "1", "filter" => $filter]));
    }
}
