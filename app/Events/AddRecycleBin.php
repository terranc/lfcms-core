<?php

namespace App\Events;

use App\Models\Document\Document;
use App\Models\RecycleBin\RecycleBin;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AddRecycleBin
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($object)
    {
        RecycleBin::create([
            'object_id' => $object->id,
            'table_name' => $object->getTable(),
            'name' => $object->title ?? $object->name,
            'created_at' => Carbon::now(),
        ]);
    }
}
