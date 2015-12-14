<?php

/**
 * @Author: dingyong
 * @Date: 2015/12/2 9:45
 */
class Fly
{

    /**
     *
     * @var Fly
     */
    private static $instance;

    /**
     * Router
     *
     * @var \fly\fly\Router
     */
    private $router;

    /**
     * Request
     *
     * @var \fly\fly\Request
     */
    private $request;

    /**
     * Response
     *
     * @var \fly\fly\Response
     */
    private $response;

    /**
     * Controller
     *
     * @var \fly\fly\Controller
     */
    private $controller;

    /**
     * set constructor private to refuse it init outside
     */
    private function __construct()
    {
        $this->init();
    }

    private function __clone()
    {
        // forbiden clone the Fly instance
    }

    /**
     * 单例初始化
     *
     * @throws \fly\fly\SysException
     */
    private function init()
    {
        if (! defined('DS')) {
            define('DS', DIRECTORY_SEPARATOR);
        }
        
        if (! defined('SYS_PATH')) {
            define('SYS_PATH', dirname(__FILE__));
        }
        
        if (! defined('NAMESPACE_APP_NAME')) {
            throw new \fly\fly\SysException('Please define NAMESPACE_APP_NAME first in the index.php');
        }
        
        if (! defined('NAMESPACE_SYS_NAME')) {
            define('NAMESPACE_SYS_NAME', 'fly');
        }
        
        include_once (SYS_PATH . 'autoload' . DS . 'functions.php');
    }

    /**
     *
     * @return Fly
     */
    public static function &getInstance()
    {
        if (! self::$instance) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }

    /**
     * set request before invoke run()
     *
     * @param
     *            $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    public function getRequest()
    {
        return $this->request;
    }

    /**
     * set response before invoke run()
     *
     * @param
     *            $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    public function getResponse()
    {
        return $this->response;
    }

    /**
     * set router
     *
     * @param \fly\fly\Router $router            
     */
    public function setRouter($router)
    {
        $this->router = $router;
    }

    public function getRouter()
    {
        return $this->router;
    }

    public function run()
    {
        $this->beforeRun();
        
        $interceptors = $this->getInterceptors();
        
        if ($interceptors) {
            $interceptors = is_array($interceptors) ? $interceptors : array(
                $interceptors
            );
            
            foreach ($interceptors as $interceptor) {
                $obj_interceptor = new $interceptor();
                $before_interceptor_result = $obj_interceptor->before();
                
                if ($before_interceptor_result == \fly\interceptors\SysGlobalInterceptor::STEP_BREAK) {
                    continue;
                } elseif ($before_interceptor_result == \fly\interceptors\SysGlobalInterceptor::STEP_EXIT) {
                    break;
                }
            }
        }
        
        $route_matches = $this->getRouteMatches();
        $controller = $this->getController();
        $this->controller = $controller;
        
        var_dump($controller);
    }

    private function beforeRun()
    {
        if (empty($this->router)) {
            $this->router = \fly\fly\Router::getInstance();
        }
        
        if (empty($this->request)) {
            $this->request = \fly\fly\Request::getInstance();
        }
        
        if (empty($this->response)) {
            $this->response = \fly\fly\Response::getInstance();
        }
    }

    public function getRouteMatches()
    {
        return $this->router->getRouteMatches();
    }

    public function getController()
    {
        return $this->router->getController();
    }

    public function getInterceptors()
    {
        return $this->router->getInterceptors();
    }
}