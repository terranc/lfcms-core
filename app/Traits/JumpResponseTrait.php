<?php
/**
 * Author: Lookfeel
 * Homepage: http://lookfeel.co
 * Date: 16/8/24
 * Time: 09:56
 */
namespace App\Traits;

trait JumpResponseTrait {

    /**
     * @param string $message
     * @param string $url
     * @param int $wait
     *
     * @return mixed
     */
    protected function success($message = '', $url = '', $wait = 1) {
        return $this->dispatchJump($message, 200, $url, $wait);
    }

    /**
     * @param string $message
     * @param string $url
     * @param int $wait
     *
     * @return mixed
     */
    protected function error($message = '', $url = '', $wait = 3) {
        return $this->dispatchJump($message, -1, $url, $wait);
    }

    /**
     * @param $message
     * @param int $code
     * @param string $url
     * @param $wait
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function dispatchJump($message, $code = 200, $url='', $wait) {
        if (request()->wantsJson() || request()->ajax()) {
            $data['message'] = $message;
            $data['code'] = $code;
            $data['data'] = $url;
            return $this->apiResponse($data);
        }

        $data['code'] = $code; // 状态
        if ($code > 0) {
            //发送成功信息
            $data['message'] = $message; // 提示信息

            // 默认操作成功自动返回操作前页面
            if (empty($url)) {
                $data["url"] = $_SERVER["HTTP_REFERER"];
            }
            return response()->view('admin.public.jump', $data);
        } else {
            $data['error'] = $message; // 提示信息
            $data['wait'] = $wait;

            // 默认发生错误的话自动返回上页
            if (empty($url)) {
                $data['url'] = "javascript:history.back(-1);";
            } else {
                $data['url'] = $url;
            }
            return response()->view('admin.public.jump', $data);
        }
    }
}
