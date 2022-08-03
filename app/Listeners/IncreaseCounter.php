<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\VideoViewer;
class IncreaseCounter
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
     * @param  object  $event
     * @return void
     */
    public function handle(VideoViewer $event)
    {
        $this -> updateViwer($event -> video);
    }

    function updateViwer($video){

        $video -> viwers = $video -> viwers +1;

        $video -> save();
    }
}
