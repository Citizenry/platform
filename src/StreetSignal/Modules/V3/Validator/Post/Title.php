<?php

/**
 * StreetSignal Post Varchar Validator
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Validator\Post;

class Title extends Varchar
{
    protected function validate($value)
    {
        if (!is_scalar($value)) {
            return 'scalar';
        }
        if (!\Kohana\Validation\Valid::max_length($value, 255)) {
            return 'max_length';
        }
    }
}
