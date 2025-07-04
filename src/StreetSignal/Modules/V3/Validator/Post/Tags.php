<?php

/**
 * StreetSignal Post Media Validator
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Validator\Post;

use StreetSignal\Contracts\Repository\Entity\TagRepository;

class Tags extends ValueValidator
{
    protected $repo;

    public function __construct(TagRepository $tags_repo)
    {
        $this->repo = $tags_repo;
    }

    protected function validate($value)
    {
        if (is_array($value)) {
            $value = $value['id'];
        }

        if (!$this->repo->doesTagExist($value)) {
            return 'tagExists';
        }
    }
}
