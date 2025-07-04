<?php

/**
 * StreetSignal Platform File Data
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Tool;

class FileData extends Data
{
    /**
     * @var string $file filesystem path
     */
    public $file;

    /**
     * @var string $type MIME type
     */
    public $type;

    /**
     * @var integer $size in bytes
     */
    public $size;

    /**
     * @var integer $width image width (if image)
     */
    public $width;

    /**
     * @var integer $height image height (if image)
     */
    public $height;
}
