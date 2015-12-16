<?php

/**
 * @Author: dingyong
 * @Date: 2015/12/2 10:18
 */
namespace fly\fly;

use \fly\utils as f_utils;

class Request
{

    /**
     *
     * @var Request
     */
    private static $instance;

    private function __construct()
    {}

    /**
     *
     * @return Request
     */
    public static function &getInstance()
    {
        if (! self::$instance) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }

    public function getFullUrl()
    {
        return f_utils\FlyUrl::getFullUrl();
    }

    public function getRequestUri()
    {
        return f_utils\FlyUrl::getRequestUri();
    }

    public function getQueryString()
    {
        return f_utils\FlyUrl::getQueryString();
    }
}