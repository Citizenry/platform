<?php
/**
 * *
 *  * StreetSignal Acl
 *  *
 *  * @author     StreetSignal Team <team@streetsignal.com>
 *  * @package    StreetSignal\Application
 *  * @copyright  2020 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 *  * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 *
 *
 */

namespace StreetSignal\Modules\V5\Common;

use Illuminate\Support\Facades\Validator;

class ValidatorRunner
{

    public static function runValidation($data, $rules, $messages)
    {
        $v = Validator::make($data, $rules, $messages);
        // check for failure
        if (!$v->fails()) {
            return new ValidationResponse(true, null);
        }
        // set errors and return false
        return new ValidationResponse(false, $v->errors());
    }
}
