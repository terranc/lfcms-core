<?php
/**
 * Created by PhpStorm.
 * User: KEL
 * Date: 2016/8/22
 * Time: 18:41
 */

namespace App\Traits;


/**
 * Class JsonResponseTrait
 * @package App\Traits
 */
trait FlashResponseTrait {

    public function flash($message = '', $level = 'success')
    {
        flash($message, $level)->important();
        return redirect($_SERVER['HTTP_REFERER']);
    }

}
