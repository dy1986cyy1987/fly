<?php

/**
 * @Author: dingyong
 * @Date: 2015/12/2 10:18
 */
namespace fly\fly;

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
        return \fly\utils\FlyUrl::getFullUrl();
    }

    public function getRequestUri()
    {
        return \fly\utils\FlyUrl::getRequestUri();
    }

    public function getQueryString()
    {
        return \fly\utils\FlyUrl::getQueryString();
    }
}