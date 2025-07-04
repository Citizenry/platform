<?php

/**
 * StreetSignal Post Relation Validator
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Validator\Post;

use StreetSignal\Core\Entity\PostRepository;

class Relation extends ValueValidator
{
    protected $repo;

    public function __construct(PostRepository $repo)
    {
        $this->repo = $repo;
    }

    protected function validate($value)
    {
        if (!\Kohana\Validation\Valid::digit($value)) {
            return 'digit';
        }

        if (! $this->repo->exists($value)) {
            return 'exists';
        }

        $post = $this->repo->get($value);
        if (is_int($this->config['input']['form']) && $post->form_id !== $this->config['input']['form']) {
            return 'invalidForm';
        }
    }
}
