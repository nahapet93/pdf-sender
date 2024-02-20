<?php

namespace App\Listeners;

use App\Events\FileSent;
use App\Models\File;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class DeleteSentFile
{
    /**
     * Handle the event.
     */
    public function handle(FileSent $event): void
    {
        $existingFile = File::first();

        if ($existingFile) {
            $existingFile->delete();
        }
    }
}
