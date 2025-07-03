<?php

/**
 * StreetSignal Notification Validator
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Validator\Notification;

use StreetSignal\Modules\V3\Validator\LegacyValidator;
use StreetSignal\Contracts\Repository\Entity\SetRepository;
use StreetSignal\Contracts\Repository\Entity\UserRepository;

class Update extends LegacyValidator
{
    protected $user_repo;
    protected $collection_repo;
    protected $savedsearch_repo;
    protected $default_error_source = 'notification';

    public function __construct(
        UserRepository $user_repo,
        SetRepository $collection_repo,
        SetRepository $savedsearch_repo
    ) {
        $this->user_repo = $user_repo;
        $this->collection_repo = $collection_repo;
        $this->savedsearch_repo = $savedsearch_repo;
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
            'set_id' => [
                ['numeric'],
                [[$this, 'exists'], [':value']],
            ]
        ];
    }

    public function exists($set_id)
    {
        return $this->collection_repo->exists($set_id) or $this->savedsearch_repo->exists($set_id);
    }
}
