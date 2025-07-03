<?php
/**
 * StreetSignal Post Video Validator
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2016 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Validator\Post;

class Video extends ValueValidator
{
    protected function validate($value)
    {
        if (!\Kohana\Validation\Valid::url($value)) {
            return 'url';
        }
        if (!$this->checkVideoTypes($value)) {
            return 'video_type';
        }
    }

    protected function checkVideoTypes($value)
    {
        return (strpos($value, 'youtube') !== false || strpos($value, 'vimeo') !== false);
    }
}
