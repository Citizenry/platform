<?php

/**
 * StreetSignal Post Varchar Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Repository\Post;

use StreetSignal\Core\Entity\PostValue;

class IntegerRepository extends ValueRepository
{
    // OhanzeeRepository
    protected function getTable()
    {
        return 'post_int';
    }

    // OhanzeeRepository
    public function getEntity(array $data = null)
    {
        $data['value'] = intval($data['value']);
        return new PostValue($data);
    }
}
