<?php

/**
 * StreetSignal Tag Validator
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Validator\Tag;

class Create extends Update
{
    protected function getRules()
    {
        return array_merge_recursive(parent::getRules(), [
            'tag' => [
                ['not_empty'],
            ],
            'slug' => [
                ['not_empty'],
            ],
            'type' => [
                ['not_empty'],
            ],
        ]);
    }
}
