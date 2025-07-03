<?php

/**
 * StreetSignal Set Validator
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Validator\Set\Post;

use StreetSignal\Modules\V3\Validator\LegacyValidator;
use StreetSignal\Contracts\Repository\Entity\PostRepository;

class Create extends LegacyValidator
{
    protected $post_repo;
    protected $default_error_source = 'set';

    public function __construct(PostRepository $post_repo)
    {
        $this->post_repo = $post_repo;
    }

    protected function getRules()
    {
        return [
            'id' => [
                ['not_empty'],
                ['digit'],
                [[$this->post_repo, 'exists'], [':value']],
            ],
        ];
    }
}
