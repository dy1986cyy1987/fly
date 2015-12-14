<?php

/**
 * @Author: dingyong
 * @Date: 2015/12/2 10:18
 */
namespace fly\fly;

class Response
{

    /**
     *
     * @var Response
     */
    private static $instance;

    private function __construct()
    {}

    /**
     *
     * @return Response
     */
    public static function &getInstance()
    {
        if (! self::$instance) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }

    public function getRouteMatches()
    {}

    public function getRouteMappings()
    {}
}