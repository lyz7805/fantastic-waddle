<?php

/**
 * 用法：
 * //load_trait('controller/Jump'); TP6 无此helper方法，可自行实现
 * class index
 * {
 *     use \traits\controller\Jump;
 *     public function index(){
 *         $this->error();
 *         $this->redirect();
 *     }
 * }
 */

declare(strict_types=1);

namespace lyz7805\think\library\traits\controller;

use think\facade\Config;
use think\exception\HttpResponseException;
use think\facade\Request;
use think\Response;
use think\response\Redirect;
use think\facade\Route;
use think\facade\View;

trait Jump
{
    /**
     * 操作成功跳转的快捷方法
     * @access protected
     * @param mixed  $msg    提示信息
     * @param string $url    跳转的 URL 地址
     * @param mixed  $data   返回的数据
     * @param int    $wait   跳转等待时间
     * @param array  $header 发送的 Header 信息
     * @return void
     * @throws HttpResponseException
     */
    protected function success($msg = '', $url = null, $data = '', int $wait = 3, array $header = [])
    {
        if (is_null($url) && !is_null(Request::server('HTTP_REFERER'))) {
            $url = Request::server('HTTP_REFERER');
        } elseif ('' !== $url && !strpos($url, '://') && 0 !== strpos($url, '/')) {
            $url = Route::buildUrl($url);
        }

        $type = $this->getResponseType();
        $result = [
            'code' => 1,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
        ];

        if ('html' == strtolower($type)) {
            $result = View::fetch(Config::get('view.dispatch_success_tmpl'), $result);
        }

        $response = Response::create($result, $type)->header($header);

        throw new HttpResponseException($response);
    }

    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param mixed  $msg    提示信息
     * @param string $url    跳转的 URL 地址
     * @param mixed  $data   返回的数据
     * @param int    $wait   跳转等待时间
     * @param array  $header 发送的 Header 信息
     * @return void
     * @throws HttpResponseException
     */
    protected function error($msg = '', $url = null, $data = '', int $wait = 3, array $header = [])
    {
        if (is_null($url)) {
            $url = Request::isAjax() ? '' : 'javascript:history.back(-1);';
        } elseif ('' !== $url && !strpos($url, '://') && 0 !== strpos($url, '/')) {
            $url = Route::buildUrl($url);
        }

        $type = $this->getResponseType();
        $result = [
            'code' => 0,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
        ];

        if ('html' == strtolower($type)) {
            $result = View::fetch(Config::get('response.dispatch_error_tmpl'), $result);
        }

        $response = Response::create($result, $type)->header($header);

        throw new HttpResponseException($response);
    }

    /**
     * 返回封装后的 API 数据到客户端
     * @access protected
     * @param mixed  $data   要返回的数据
     * @param int    $code   返回的 code
     * @param mixed  $msg    提示信息
     * @param string $type   返回数据格式
     * @param array  $header 发送的 Header 信息
     * @return void
     * @throws HttpResponseException
     */
    protected function result($data, int $code = 0, $msg = '', string $type = '', array $header = [])
    {
        $result = [
            'code' => $code,
            'msg'  => $msg,
            'time' => Request::server('REQUEST_TIME'),
            'data' => $data,
        ];
        $type     = $type ?: $this->getResponseType();
        $response = Response::create($result, $type)->header($header);

        throw new HttpResponseException($response);
    }

    /**
     * URL 重定向
     * @access protected
     * @param string    $url    跳转的 URL 表达式
     * @param int       $code   http code
     * @param array     $with   隐式传参
     * @param array     $params 其它 URL 参数，必要性不大，尽量在 $url 参数中直接加入参数
     * @return void
     * @throws HttpResponseException
     */
    protected function redirect($url, int $code = 302, array $with = [], array $params = [])
    {
        if (strpos($url, '://') || (0 === strpos($url, '/') && empty($params)) || (is_object($url) && empty($params))) {
            $data = $url;
        } else {
            if (is_object($url)) {
                /**
                 * 如果为Url对象，则更新参数， 此参数会覆盖已经设置的参数
                 * @var \think\Route\Url
                 */
                $data = $url->vars($params);
            } else {
                $data = Route::buildUrl($url, $params);
            }
        }

        /**
         * @var Redirect
         */
        $response = Response::create($data, 'redirect', $code);
        $response->code($code)->with($with);

        throw new HttpResponseException($response);
    }

    /**
     * 获取当前的 response 输出类型
     * @access protected
     * @return string
     */
    protected function getResponseType()
    {
        return Request::isJson()
            ? 'json' : (Request::isAjax()
                ? Config::get('response.default_ajax_return', 'json')
                : Config::get('response.default_return_type', 'html'));
    }
}
