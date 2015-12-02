<?php

/**
 * @Author: dingyong
 * @Date: 2015/12/2 9:45
 */
class Fly {

    /**
     * @var Fly
     */
    private static $instance;

    /**
     * @var fly\Controller
     */
    private $controller;

    /**
     * @var fly\Request
     */
    private $request;

    /**
     * @var fly\Response
     */
    private $response;

    /**
     * set constructor private to refuse it init outside
     */
    private function __construct() {
        if (!defined('DS')) {
            define('DS', DIRECTORY_SEPARATOR);
        }

        if (!defined('SYS_PATH')) {
            define('SYS_PATH', dirname(__FILE__));
        }

        include_once(SYS_PATH . 'autoload' . DS . 'functions.php');
    }

    /**
     * @return Fly
     */
    public static function &getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * set request before invoke run()
     * @param $request
     */
    public function setRequest($request) {
        self::getInstance()->request = $request;
    }

    /**
     * set response before invoke run()
     * @param $response
     */
    public function setResponse($response) {
        self::getInstance()->response = $response;
    }

    public function run() {
        \app\controller\LanguageController::main();
    }
}