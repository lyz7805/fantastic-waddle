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
    'dispatch_success_tmpl'  => root_path() . 'vendor' . DIRECTORY_SEPARATOR . 'lyz7805' . DIRECTORY_SEPARATOR . 'tp-response' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'tpl' . DIRECTORY_SEPARATOR . 'dispatch_jump.tpl',
    'dispatch_error_tmpl'    => root_path() . 'vendor' . DIRECTORY_SEPARATOR . 'lyz7805' . DIRECTORY_SEPARATOR . 'tp-response' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'tpl' . DIRECTORY_SEPARATOR . 'dispatch_jump.tpl',
];