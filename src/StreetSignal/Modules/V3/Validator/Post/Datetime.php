<?php

/**
 * StreetSignal Post Date Validator
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Validator\Post;

class Datetime extends ValueValidator
{
    protected function validate($value)
    {
        if (!\Kohana\Validation\Valid::date($value)) {
            return 'date';
        }
    }
}
