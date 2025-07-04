<?php

/**
 * StreetSignal Post Geometry Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Repository\Post;

use Ohanzee\DB;
use StreetSignal\Core\Entity\PostValue;
use StreetSignal\Core\Entity\PostValueRepository as PostValueRepositoryContract;

class GeometryRepository extends ValueRepository
{
    // OhanzeeRepository
    protected function getTable()
    {
        return 'post_geometry';
    }

    // Override selectQuery to fetch 'value' from db as text
    protected function selectQuery(array $where = [])
    {
        $query = parent::selectQuery($where);

        // Get geometry value as text
        $query->select(
            $this->getTable().'.*',
            // Fetch ST_AsText(value) aliased to value
                [DB::expr('ST_AsText(value)'), 'value']
        );

        return $query;
    }

    protected function prepareValue($value)
    {
        return DB::expr('ST_GeomFromText(:text)')->param(':text', $value);
    }
}
