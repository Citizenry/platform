<?php
namespace StreetSignal\Core\Usecase\User;

use StreetSignal\Contracts\Entity;
use StreetSignal\Core\Usecase\UpdateUsecase;

class UpdateUser extends UpdateUsecase
{
    protected function sendNotifications(Entity $entity)
    {
        if ($entity->hasChanged('password')) {
            // Email the update message
            $message = <<<TEXT
            This is a notification to let you know that your StreetSignal password has been changed for the deployment.
            If you believe that you received this notification in error or you did not make this change,
            please contact your deployment administrator first to confirm if this was an administrative change.
            If not, feel free to contact the StreetSignal Support team.
            Thank you,
            StreetSignal Support.
TEXT;
            $source = app('datasources')->getSource('outgoingemail');
            $source->send($entity->email, $message, 'StreetSignal Account Password Changed');
        }
    }
}
