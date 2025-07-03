<?php

namespace StreetSignal\Modules\V3;

use Illuminate\Contracts\Events\Dispatcher;
use StreetSignal\Modules\V3\Listener\CreatePostFromMessage;
use StreetSignal\Modules\V3\Listener\HandleTargetedSurveyResponse;
use StreetSignal\Modules\V3\Listener\QueueExportJob;

class EventSubscriber
{

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            'message.receive',
            HandleTargetedSurveyResponse::class
        );

        $events->listen(
            'message.receive',
            CreatePostFromMessage::class
        );

        $events->listen(
            'export_job.create',
            QueueExportJob::class
        );
    }
}
