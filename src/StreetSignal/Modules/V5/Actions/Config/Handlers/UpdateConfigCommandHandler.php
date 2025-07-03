<?php

namespace StreetSignal\Modules\V5\Actions\Config\Handlers;

use App\Bus\Action;
use App\Bus\Command\AbstractCommandHandler;
use App\Bus\Command\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use StreetSignal\Modules\V5\Models\Config;
use StreetSignal\Core\Concerns\Event;
use StreetSignal\Modules\V5\Repository\Config\ConfigRepository;
use StreetSignal\Modules\V5\Actions\Config\Commands\UpdateConfigCommand;
use Illuminate\Support\Facades\DB;
use StreetSignal\Core\Entity\Config as ConfigEntity;
use StreetSignal\Core\Exception\NotFoundException;
use StreetSignal\Core\Exception\AuthorizerException;
use StreetSignal\Modules\V5\Helpers\ParameterUtilities;

class UpdateConfigCommandHandler extends AbstractCommandHandler
{
    // Use Event trait to trigger events
    use Event;
    private $config_repository;

    public function __construct(ConfigRepository $config_repository)
    {
        $this->config_repository = $config_repository;
    }

    protected function isSupported(Command $command): void
    {
        if (!$command instanceof UpdateConfigCommand) {
            throw new \Exception('Provided $command is not instance of UpdateConfigCommand');
        }
    }

    public function __invoke(Action $action)
    {
        /**
         * @var UpdateConfigCommand $action
         */
        $this->isSupported($action);


        $this->updateConfig($action);
    }


    private function updateConfig(UpdateConfigCommand $action)
    {

        $this->verifyGroup($action->getGroupName());

        if ($action->getGroupName() == 'deployment_id') {
            return; /* noop */
        }
        foreach ($action->getInsertConfigs() as $key => $value) {
            $this->config_repository->createByKey($action->getGroupName(), $key, $value);
        }

        foreach ($action->getUpdateConfigs() as $key => $value) {
            $this->config_repository->updateOrInsertByKey($action->getGroupName(), $key, $value);
        }

        foreach ($action->getDeleteConfigs() as $key => $value) {
            $this->config_repository->deleteByKey($action->getGroupName(), $key);
        }

        // To Do  add intercom event from V3
    }

    protected function verifyGroup($group)
    {
        if (!in_array($group, Config::AVIALABLE_CONFIG_GROUPS)) {
            throw new NotFoundException("Requested group does not exist: " . $group);
        }
        if (!ParameterUtilities::checkIfUserAdmin() && (!in_array($group, Config::AVIALABLE_CONFIG_GROUPS_FOR_NON_ADMIN))) {
            throw new AuthorizerException();
        }
    }
}
