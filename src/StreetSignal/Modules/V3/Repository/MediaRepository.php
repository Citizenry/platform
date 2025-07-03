<?php

/**
 * StreetSignal Media Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Repository;

use StreetSignal\Core\Tool\SearchData;
use StreetSignal\Core\Entity\Media;
use StreetSignal\Contracts\Repository\Entity\MediaRepository as MediaRepositoryContract;
use StreetSignal\Core\Tool\Uploader;

class MediaRepository extends OhanzeeRepository implements
    MediaRepositoryContract
{
    private $upload;

    private $created_id;
    private $created_ts;

    private $deleted_media;

    public function __construct(\StreetSignal\Core\Tool\OhanzeeResolver $resolver, Uploader $upload)
    {
        parent::__construct($resolver);

        $this->upload = $upload;
    }

    // OhanzeeRepository
    protected function getTable()
    {
        return 'media';
    }

    // OhanzeeRepository
    public function getEntity(array $data = null)
    {
        return new Media($data);
    }

    // SearchRepository
    public function getSearchFields()
    {
        return ['user', 'orphans'];
    }

    // OhanzeeRepository
    protected function setSearchConditions(SearchData $search)
    {
        if ($search->user) {
            $this->search_query->where('user_id', '=', $search->user);
        }

        if ($search->orphans) {
            $this->search_query
                ->join('posts_media', 'left')
                    ->on('posts_media.media_id', '=', 'media.id')
                ->where('posts_media.post_id', 'is', null);
        }
    }
}
