<?php
/**
 * Created by PhpStorm.
 * User: terranc
 * Date: 17/6/24
 * Time: 19:41
 */

namespace App\Http\Controllers\Api\V1;

use App\Models\Document\Document;

class IndexController extends BaseController
{

    public function index()
    {
        dd(Document::destroy(Document::first()->id));
        dd(config('global'));
    }

}
