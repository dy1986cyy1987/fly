<?php

set_include_path(get_include_path() . PATH_SEPARATOR . SYS_PATH . 'fly');

/**
 * @param $className
 *
 * @throws \fly\fly\SysException
 */
function autoload($className)
{

    if (empty($className)) {
        throw new \fly\fly\SysException(json_encode(array(
            'status' => '100001',
            'errorMsg' => 'Class name is null!'
        )));
    }

    $is_linux_os = DS == '/';

    // namespace process
    $php_file_prefix = str_replace('\\', DS, $className);
    
    $php_file = $php_file_prefix . '.php';
    
    trim($php_file, DS);
    
    $regex_fly = '/^(' . NAMESPACE_SYS_NAME . ')/';
    $regex_app = '/^(' . NAMESPACE_APP_NAME . ')/';
    
    if (preg_match($regex_fly, $php_file)) {
        $arr_exp = explode(DS, $php_file);
        $arr_exp[0] = trim(SYS_PATH, DS);
        $php_file = implode(DS, $arr_exp);
    } elseif (preg_match($regex_app, $php_file)) {
        $arr_exp = explode(DS, $php_file);
        $arr_exp[0] = trim(APP_PATH, DS);
        $php_file = implode(DS, $arr_exp);
    } else {
        throw new \fly\fly\SysException(json_encode(array(
            'status' => 10002,
            'errorMsg' => 'Don\'t support the your private namespace! Only support namespace (' . NAMESPACE_APP_NAME . ', ' . NAMESPACE_SYS_NAME . ')'
        )));
    }

    $php_file = $is_linux_os ? DS . $php_file : $php_file;

    if (! file_exists($php_file)) {
        throw new \fly\fly\SysException(json_encode(array(
            'status' => 10003,
            'errorMsg' => 'File not exist!'
        )));
    }

    include_once($php_file);
}

spl_autoload_register('autoload');
