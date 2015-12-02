<?php

/**
 * autoload action
 * @param $className
 */
function autoload($className)
{

    global $G_APP_AUTOLOAD_PATH;
    $sys_load_path = include(SYS_PATH . 'autoload' . DS . 'loadpath.php');

    // namespace process
    if (strpos($className, '\\')) {
        $exp = explode('\\', $className);
        $className = end($exp);
    }

    $php_file = $className . '.php';

    if (!file_exists($php_file)) {

        if (empty($G_APP_AUTOLOAD_PATH)) {
            $G_APP_AUTOLOAD_PATH = array();
        }

        $load_path = array_merge(
            $G_APP_AUTOLOAD_PATH,
            $sys_load_path
        );

        foreach ($load_path as $path) {
            if (file_exists($path . $php_file)) {
                include_once($path . $php_file);
                break;
            } else {
                // foreach internal directories
                $dirs = deepScanDir($path);

                if ($dirs && count($dirs) > 1) {
                    foreach ($dirs as $sub_path) {

                        if (file_exists($sub_path . $php_file)) {
                            include_once($sub_path . $php_file);
                            break;
                        }
                    }
                }
            }
        }
    } else {
        include_once($php_file);
    }
}

spl_autoload_register('autoload');

// must be declared as global
$G_DIR_ARR = array();

/**
 * get sub directory
 * @param $dir
 * @return array
 */
function deepScanDir($dir)
{
    global $G_DIR_ARR;
    $dir = rtrim($dir, '\/');
    $G_DIR_ARR[] = $dir . DS;

    if (is_dir($dir)) {
        $dirHandle = opendir($dir);
        while (false !== ($fileName = readdir($dirHandle))) {
            $subFile = $dir . DIRECTORY_SEPARATOR . $fileName;
            if (is_dir($subFile) && str_replace('.', '', $fileName) != '') {
                deepScanDir($subFile);
            }
        }
        closedir($dirHandle);
    }

    return $G_DIR_ARR;
}