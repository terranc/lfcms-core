<?php

namespace App\Http\Controllers;

use App\Traits\FlashResponseTrait;
use App\Traits\JsonResponseTrait;
use App\Traits\JumpResponseTrait;
use Illuminate\Foundation\Bus\DispatchesJobs;
use \Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, JsonResponseTrait, JumpResponseTrait, FlashResponseTrait;
    //
    public $request;
    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->request = request();
    }



}
