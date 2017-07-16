<?php
/**
 * Created by PhpStorm.
 * User: terranc
 * Date: 17/7/15
 * Time: 12:03
 */

namespace App\Http\Controllers\Api\V1;


use Illuminate\Http\Request;
use Upyun\Uploader;

class CommonController extends BaseController
{

    public function ueditorUpload(Request $request)
    {
        $upload = config('ueditor.upload');
        $storage = app('ueditor.storage');

        switch ($request->get('action')) {
            case 'config':
                return config('ueditor.upload');
            // lists
            case $upload['imageManagerActionName']:
                return $storage->listFiles(
                    $upload['imageManagerListPath'],
                    $request->get('start'),
                    $request->get('size'),
                    $upload['imageManagerAllowFiles']);
            case $upload['fileManagerActionName']:
                return $storage->listFiles(
                    $upload['fileManagerListPath'],
                    $request->get('start'),
                    $request->get('size'),
                    $upload['fileManagerAllowFiles']);
            default:
                return $storage->upload($request);
        }
    }

}
