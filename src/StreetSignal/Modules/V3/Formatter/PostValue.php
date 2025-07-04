<?php

/**
 * StreetSignal API Formatter for Post Values
 *
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Formatter;

class PostValue extends API
{
    protected $map = [];

    public function __construct($map = [])
    {
        $this->map = $map;
    }

    public function __invoke($entity)
    {
        if (isset($this->map[$entity->type])) {
            $formatter = $this->map[$entity->type];
            return $formatter($entity);
        }

        return $entity->value;
    }
}
