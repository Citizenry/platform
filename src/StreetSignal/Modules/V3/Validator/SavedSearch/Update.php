<?php

/**
 * StreetSignal Set Validator
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Validator\SavedSearch;

use StreetSignal\Modules\V3\Validator\Set;

class Update extends Set\Update
{
    protected function getRules()
    {
        return array_merge_recursive(parent::getRules(), [
            'filter' => [
                ['is_array', [':value']]
            ]
        ]);
    }
}
