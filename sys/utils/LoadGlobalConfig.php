<?php
namespace fly\utils;

class LoadGlobalConfig
{

    /**
     * load route config
     *
     * @param unknown $config_key            
     */
    public static function loadRouteConfig($config_key = null)
    {
        $file = APP_PATH . 'config' . DS . 'route.php';
        
        $route_config = \fly\utils\Import::getInstance()->importFile($file);
        
        if (! empty($config_key) && isset($route_config[$config_key]) && ! empty($route_config[$config_key])) {
            return $route_config[$config_key];
        }
        
        return $route_config;
    }

    /**
     *
     * @return string|array
     */
    public static function loadRouteMappings()
    {
        return self::loadRouteConfig('route_mappings');
    }

    /**
     * load sys global interceptors
     *
     * @return array
     */
    public static function loadSysInterceptors()
    {
        $file = SYS_PATH . 'config' . DS . 'interceptors.php';
        
        if (file_exists($file)) {
            return \fly\utils\Import::getInstance()->importFile($file);
        }
        
        return array();
    }

    /**
     * load app global interceptors
     *
     * @return array
     */
    public static function loadAppInterceptors($controller = null)
    {
        $file = APP_PATH . 'config' . DS . 'interceptors.php';
        
        if (file_exists($file)) {
            $config = \fly\utils\Import::getInstance()->importFile($file);
            ;
            $global_interceptor = isset($config['global']) ? $config['global'] : array();
            $current_interceptor = ! empty($controller) && isset($config[$controller]) ? $config[$controller] : array();
            
            $interceptors = array_merge($global_interceptor, $current_interceptor);
            
            if (! empty($interceptors)) {
                return array_unique($interceptors);
            }
        }
        
        return array();
    }
}