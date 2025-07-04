<?php

/**
 * StreetSignal Post Media Validator
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Validator\Post;

use StreetSignal\Contracts\Repository\Entity\MediaRepository;

class Media extends ValueValidator
{
    protected $media_repo;

    public function __construct(MediaRepository $media_repo)
    {
        $this->repo = $media_repo;
    }

    protected function validate($value)
    {
        if (!\Kohana\Validation\Valid::digit($value)) {
            return 'digit';
        }

        if (! $this->repo->exists($value)) {
            return 'exists';
        }
    }
}
