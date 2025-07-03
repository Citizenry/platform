<?php

namespace StreetSignal\Modules\V5\Actions\Post\Handlers;

use App\Bus\Action;
use App\Bus\Command\Command;
use StreetSignal\Modules\V5\Actions\V5CommandHandler;
use StreetSignal\Modules\V5\Actions\Post\Commands\DeletePostLockCommand;
use StreetSignal\Modules\V5\Repository\Post\PostLockRepository;

class DeletePostLockCommandHandler extends V5CommandHandler
{
    private $post_lock_repository;
    public function __construct(PostLockRepository $post_lock_repository)
    {
        $this->post_lock_repository = $post_lock_repository;
    }

    protected function isSupported(Command $command)
    {
        if (!$command instanceof DeletePostLockCommand) {
            throw new \Exception('Provided command is not of type ' . DeletePostLockCommand::class);
        }
    }

    public function __invoke(Action $action)
    {
        /**
         * @var DeletePostLockCommand $action
         */
         // To do : make it as transaction
        $this->isSupported($action);
        $this->post_lock_repository->deleteByPostId($action->getPostId());
    }
}
