<?php

namespace App\Listeners;

use App\Events\CategoryDelete;
use App\Models\Document\Document;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteDocumentByCategory
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
     * @param  CategoryDelete  $event
     * @return void
     */
    public function handle(CategoryDelete $event)
    {
        Document::where('category_id', $event->category->id)->delete();
    }
}
