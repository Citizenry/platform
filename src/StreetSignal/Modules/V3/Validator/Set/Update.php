<?php

/**
 * StreetSignal Set Validator
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Validator\Set;

use StreetSignal\Core\Concerns\UserContext;
use StreetSignal\Modules\V3\Validator\LegacyValidator;
use StreetSignal\Contracts\Repository\Entity\RoleRepository;
use StreetSignal\Contracts\Repository\Entity\UserRepository;

class Update extends LegacyValidator
{

    use UserContext;

    protected $user_repo;
    protected $role_repo;
    protected $default_error_source = 'set';

    public function __construct(UserRepository $repo, RoleRepository $role_repo)
    {
        $this->user_repo = $repo;
        $this->role_repo = $role_repo;
    }

    protected function getRules()
    {
        return [
            'id' => [
                ['numeric'],
            ],
            'user_id' => [
                ['numeric'],
                [[$this->user_repo, 'exists'], [':value']],
            ],
            'name' => [
                ['min_length', [':value', 3]],
                ['max_length', [':value', 255]],
            ],
            'user_id' => [
                [[$this->user_repo, 'exists'], [':value']],
                [[$this, 'isUserOwner'], [':fulldata']]
            ],
            'view' => [
                // @todo stop hardcoding views
                ['in_array', [':value', ['map', 'list', 'chart', 'timeline', 'data']]]
            ],
            'role' => [
                [[$this->role_repo, 'exists'], [':value']],
            ]
        ];
    }


    public function isUserOwner($entity)
    {
        return ($this->getUser() &&  $entity['user_id'] === $this->getUserId());
    }
}
