<?php

/**
 * StreetSignal User Registration Validator
 *
 * Checks the consistency of the User before registration
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Validator\User;

use StreetSignal\Modules\V3\Validator\LegacyValidator;
use StreetSignal\Contracts\Repository\Usecase\UserRegisterRepository;

class Register extends LegacyValidator
{
    protected $default_error_source = 'user';
    private $repo;

    public function __construct(UserRegisterRepository $repo)
    {
        $this->repo = $repo;
    }

    protected function getRules()
    {

        return [
            'realname' => [
                ['max_length', [':value', 150]],
            ],
            'email' => [
                ['not_empty'],
                ['max_length', [':value', 150]],
                ['email', [':value', true]],
                [[$this->repo, 'isUniqueEmail'], [':value']],
            ],
            'password' => [
                ['not_empty'],
                ['min_length', [':value', 7]],
                ['max_length', [':value', 72]]
            ]
        ];
    }
}
