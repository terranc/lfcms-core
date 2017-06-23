<?php

namespace App\Traits;


/**
 * Class FlashResponseTrait
 * @package App\Traits
 */
trait FlashResponseTrait {

    public function flash($message = '', $level = 'success')
    {
        flash($message, $level)->important();
        return redirect($_SERVER['HTTP_REFERER']);
    }

}
