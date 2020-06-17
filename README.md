# tp-response
适配ThinkPHP6.0的响应类，让响应配置、响应内容更简单、更易用

## 安装
~~~php
composer require lyz7805/tp-response
~~~

## 配置
安装之后会在config目录下生成response.php配置文件
~~~php
<?php
/**
 * 响应输出配置文件
 */
return [
    // 默认输出类型
    'default_return_type'    => 'html',
    // 默认AJAX 数据返回格式,可选json xml ...
    'default_ajax_return'    => 'json',

    // 默认跳转页面对应的模板文件
    'dispatch_success_tmpl'  => root_path() . 'vendor' . DIRECTORY_SEPARATOR . 'lyz7805' . DIRECTORY_SEPARATOR . 'tp-response' . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'dispatch_jump.tpl',
    'dispatch_error_tmpl'    => root_path() . 'vendor' . DIRECTORY_SEPARATOR . 'lyz7805' . DIRECTORY_SEPARATOR . 'tp-response' . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'dispatch_jump.tpl',
];
~~~

## 使用
使用trait：
例如使用Jump跳转类
~~~php
<?php
declare (strict_types = 1);

namespace app\controller;

use app\BaseController;
use lyz7805\think\library\traits\controller\Jump;

class Test extends BaseController
{
    // 引入跳转类，之后在控制器中即可使用success，fail，redirect，result方法实现快速跳转
    use Jump;

    public function index() {
        $msg = '成功';
        return $this->success($msg);
    }
}
~~~