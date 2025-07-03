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

class Create extends Set\Create
{
    protected function getRules()
    {
        $rules = parent::getRules();
        return array_merge_recursive($rules, [
            'name' => [
                ['not_empty'],
            ],
            'filter' => [
                ['not_empty'],
            ]
        ]);
    }
}
