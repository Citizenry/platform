<?php

/**
 * StreetSignal Export Validator
 *
 * @author    StreetSignal Team <team@streetsignal.com>
 * @package   StreetSignal\Application
 * @copyright 2014 StreetSignal
 * @license   https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Validator\ExportJob;

class Create extends Update
{
    protected function getRules()
    {
        return array_merge_recursive(parent::getRules(), [
        'entity_type' => [
        ['not_empty'],
        ],
        ]);
    }
}
