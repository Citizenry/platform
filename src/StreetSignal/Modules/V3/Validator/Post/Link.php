<?php

/**
 * StreetSignal Post Link Validator
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Validator\Post;

class Link extends ValueValidator
{
    protected function validate($value)
    {
        if (!\Kohana\Validation\Valid::url($value)) {
            return 'url';
        }
    }
}
