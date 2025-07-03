<?php

/**
 * StreetSignal Post Create Validator
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Validator\Post;

class Import extends Create
{
    protected function getRules()
    {
        // We remove the rules validating required stages
        // as stages are not validated during an import
        return array_merge(parent::getRules(), [
        'values' => [
                [[$this, 'checkValues'], [':validation', ':value', ':fulldata']]
          ],
        'completed_stages' => [
                [[$this, 'checkStageInForm'], [':validation', ':value', ':fulldata']]
        ]
        ]);
    }
}
