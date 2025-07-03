<?php

namespace StreetSignal\Modules\V3\Listener;

use StreetSignal\Contracts\Entity;
use StreetSignal\Modules\V3\Jobs\ExportPostsJob;

class QueueExportJob
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param int $id
     * @param Entity $entity
     * @return void
     */
    public function handle($id, Entity $entity)
    {
        dispatch(new ExportPostsJob($id));
    }
}
