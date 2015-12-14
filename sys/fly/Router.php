<?php

/**
 * @Author: dingyong
 * @Date: 2015/12/2 10:20
 */
namespace fly\fly;

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
     * @return Route
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
     * @return \fly\fly\Controller
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
     * get controller or route matches base on uri
     *
     * @param string $bol_ret_controller            
     * @return array|string
     */
    private function mapping($bol_ret_controller = true)
    {
        $request_uri = \fly\utils\FlyUrl::getRequestUri();
        $route_mappings = \fly\utils\LoadGlobalConfig::loadRouteMappings();
        
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
     *
     * @return array
     */
    public function getSysInterceptors()
    {
        return \fly\utils\LoadGlobalConfig::loadSysInterceptors();
    }

    /**
     *
     * @return array
     */
    public function getAppInterceptors()
    {
        return \fly\utils\LoadGlobalConfig::loadAppInterceptors($this->getController());
    }

    /**
     *
     * @return array
     */
    public function getInterceptors()
    {
        $sys_inteceptors = $this->getSysInterceptors();
        $app_inteceptors = $this->getAppInterceptors();
        
        return array_unique(array_merge($sys_inteceptors, $app_inteceptors));
    }
}