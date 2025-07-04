<?php

/**
 * StreetSignal Post Media Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Repository\Post;

class MediaRepository extends ValueRepository
{

    // OhanzeeRepository
    public function getEntity(array $data = null)
    {
        /**
         * This value is added here so that we can manipulate it in the CSV getpostvalues and use either id or filename
         * depending on the repository used
         */
        $data['value'] = ['o_filename' => $data['o_filename'], 'id' => $data['id']];
        return new \StreetSignal\Core\Entity\PostValueMedia($data);
    }

    // OhanzeeRepository
    protected function getTable()
    {
        return 'post_media';
    }

    // Override selectQuery to fetch attribute 'key' too
    protected function selectQuery(array $where = [])
    {
        $query = parent::selectQuery($where);

        // Select 'key' too
        $query->select(
            'media.o_filename',
            'media.id'
        )
        ->join('media')->on('value', '=', 'media.id');

        return $query;
    }
}
