<?php

/**
 * StreetSignal Message Validator
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Validator\Message;

use StreetSignal\Modules\V3\Validator\LegacyValidator;
use StreetSignal\Contracts\Repository\Usecase\UpdateMessageRepository;

class Update extends LegacyValidator
{
    protected $repo;
    protected $default_error_source = 'message';

    public function __construct(UpdateMessageRepository $repo)
    {
        $this->repo = $repo;
    }

    protected function getRules()
    {
        return [
            'status' => [
                [[$this->repo, 'checkStatus'], [':value', $this->validation_engine->getFullData('direction')]]
            ]
        ];
    }
}
