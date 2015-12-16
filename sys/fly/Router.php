<?php

/**
 * @Author: dingyong
 * @Date: 2015/12/2 10:20
 */
namespace fly\fly;

use \fly\utils as f_utils;

class Router
{

    /**
     *
     * @var Router
     */
    private static $instance;

    /**
     *
     * @var \fly\fly\Controller
     */
    private $controller;

    private $_index_counter = 0;

    private function __construct()
    {}

    /**
     *
     * @return \fly\fly\Router
     */
    public static function &getInstance()
    {
        if (! self::$instance) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }

    /**
     * get controller from uri
     *
     * @return String '\fly\fly\Controller'
     */
    public function getController()
    {
        if ($this->_index_counter) {
            return $this->controller;
        }
        
        return $this->mapping();
    }

    /**
     *
     * @return array
     */
    public function getRouteMatches()
    {
        return $this->mapping(false);
    }

    /**
     * @param bool|true $bol_ret_controller
     *
     * @return array|int|string
     */
    private function mapping($bol_ret_controller = true)
    {
        $request_uri = f_utils\FlyUrl::getRequestUri();
        $route_mappings = f_utils\LoadGlobalConfig::loadRouteMappings();
        
        foreach ($route_mappings as $controller => $patterns) {
            if (is_array($patterns)) {
                foreach ($patterns as $pattern) {
                    preg_match($pattern, $request_uri, $matches);
                    
                    if (! empty($matches)) {
                        $this->_index_counter ++;
                        $this->controller = $controller;
                        
                        if ($bol_ret_controller) {
                            return $controller;
                        }
                        
                        return $matches;
                    }
                }
            } else {
                preg_match($patterns, $request_uri, $matches);
                
                if (! empty($matches)) {
                    $this->_index_counter ++;
                    $this->controller = $controller;
                    
                    if ($bol_ret_controller) {
                        return $controller;
                    }
                    
                    return $matches;
                }
            }
        }
        
        if ($bol_ret_controller) {
            return '';
        }
        
        return array();
    }

    /**
     * get view file_path
     * @param        $viewName
     * @param string $ext
     *
     * @return string
     */
    public function getView($viewName, $ext = '.php'){
        $class_name = APP_PATH . 'views' . DS . $viewName . $ext;

        return $class_name;
    }

    /**
     *
     * @return array
     */
    public function getSysInterceptors()
    {
        return f_utils\LoadGlobalConfig::loadSysInterceptors();
    }

    /**
     *
     * @return array
     */
    public function getAppInterceptors()
    {
        return f_utils\LoadGlobalConfig::loadAppInterceptors($this->getController());
    }

    /**
     *
     * @return array
     */
    public function getInterceptors()
    {
        $sys_interceptors = $this->getSysInterceptors();
        $app_interceptors = $this->getAppInterceptors();
        
        return array_unique(array_merge($sys_interceptors, $app_interceptors));
    }
}