<?php

/**
 * @Author: dingyong
 * @Date  : 2015/12/2 9:45
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
     * @var \fly\fly\View
     */
    private $view;

    private $_attributes = array();

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
        if (!defined('DS')) {
            define('DS', DIRECTORY_SEPARATOR);
        }

        if (!defined('SYS_PATH')) {
            define('SYS_PATH', dirname(__FILE__));
        }

        if (!defined('NAMESPACE_APP_NAME')) {
            throw new \fly\fly\SysException('Please define NAMESPACE_APP_NAME first in the index.php');
        }

        if (!defined('NAMESPACE_SYS_NAME')) {
            define('NAMESPACE_SYS_NAME', 'fly');
        }

        include_once(SYS_PATH . 'autoload' . DS . 'functions.php');
    }

    /**
     *
     * @return Fly
     */
    public static function &getInstance()
    {
        if (!self::$instance) {
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

        // execute before interceptors
        $interceptors = $this->getInterceptors();

        $bol_exit = false;

        if ($interceptors) {
            $interceptors = is_array($interceptors) ? $interceptors : array(
                $interceptors,
            );

            foreach ($interceptors as $interceptor) {
                $obj_interceptor = new $interceptor();
                $before_interceptor_result = $obj_interceptor->before();

                if ($before_interceptor_result == \fly\interceptors\SysGlobalInterceptor::STEP_BREAK) {
                    continue;
                } elseif ($before_interceptor_result == \fly\interceptors\SysGlobalInterceptor::STEP_EXIT) {
                    $bol_exit = true;
                    break;
                }
            }
        }

        if ($bol_exit) {
            exit(0);
        }

        // execute controller without render
        $controller_name = $this->getControllerName();

        if (empty($controller_name)) {
            throw new \fly\fly\SysException('Can\'t find the controller!');
        }

        $this->controller = new $controller_name();

        if (!$this->controller->checkParams()) {
            throw new \fly\fly\SysException('Controller check params failed!');
        }

        $this->controller->beforeHandle();
        $view = $this->controller->handle();

        // execute after interceptor
        if ($interceptors) {
            $interceptors = is_array($interceptors) ? $interceptors : array(
                $interceptors,
            );

            foreach ($interceptors as $interceptor) {
                $obj_interceptor = new $interceptor();
                $before_interceptor_result = $obj_interceptor->after();

                if ($before_interceptor_result == \fly\interceptors\SysGlobalInterceptor::STEP_BREAK) {
                    continue;
                } elseif ($before_interceptor_result == \fly\interceptors\SysGlobalInterceptor::STEP_EXIT) {
                    $bol_exit = true;
                    break;
                }
            }
        }

        if ($bol_exit) {
            exit(0);
        }

        // render page
        if (!$view) {
            return false;
        }

        $this->view  = new $view();
        $this->view->render();

        return true;
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

    public function getControllerName()
    {
        return $this->router->getController();
    }

    public function getInterceptors()
    {
        return $this->router->getInterceptors();
    }

    public function setAttribute($key, $value){
        $this->_attributes[$key] = $value;
    }

    public function setAttributes($attributes = array()){
        if (is_array($attributes) && !empty($attributes)) {
            $this->_attributes = array_merge($this->_attributes, $attributes);
        }
    }

    public function getAttribute($key){
        if (array_key_exists($key, $this->_attributes)) {
            return $this->_attributes[$key];
        }

        return false;
    }

    public function getAttributes(){
        return $this->_attributes;
    }
}