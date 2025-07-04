<?php

/**
 * StreetSignal Post Lock Update Validator
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2017 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Validator\Post\Lock;

use StreetSignal\Modules\V3\Validator\LegacyValidator;
use StreetSignal\Contracts\Repository\Entity\PostRepository;

class Update extends LegacyValidator
{
    protected $post_repo;

    protected $default_error_source = 'post_lock';

    public function __construct(PostRepository $post_repo)
    {
        $this->post_repo = $post_repo;
    }

    protected function getRules()
    {
        return [
            'post_id' => [
                [[$this->post_repo, 'exists'], [':value']],
            ],
        ];
    }
}
