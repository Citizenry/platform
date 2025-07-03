<?php

/**
 * StreetSignal Post Varchar Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Repository\Post;

use StreetSignal\Core\Entity\PostValue;

class DatetimeRepository extends ValueRepository
{
    // OhanzeeRepository
    protected function getTable()
    {
        return 'post_datetime';
    }

    // StreetSignal_Repository
    public function getEntity(array $data = null)
    {
        // Replace time with 00:00:00
        if ($this->hideTime && $postDate = date_create($data['value'], new \DateTimeZone('UTC'))) {
            $data['value'] = $postDate->setTime(0, 0, 0)->format('Y-m-d H:i:s');
        }

        return new PostValue($data);
    }

    protected function prepareValue($value)
    {
        return date("Y-m-d H:i:s", strtotime($value));
    }

    protected $hideTime = false;

    public function hideTime($hide = true)
    {
        $this->hideTime = $hide;
    }
}
