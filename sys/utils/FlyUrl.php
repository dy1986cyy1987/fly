<?php

/**
 * @Author: dingyong
 * @Date: 2015/12/2 10:29
 */
namespace fly\utils;

class FlyUrl
{

    /**
     * is https
     *
     * @return bool
     */
    public static function isSecurity()
    {
        if (strtolower($_SERVER['REQUEST_SCHEME']) === 'https') {
            return true;
        }
        
        return false;
    }

    /**
     * get protocol
     *
     * @return string https|http
     */
    public static function getProtocol()
    {
        if (self::isSecurity()) {
            return 'https';
        }
        
        return 'http';
    }

    /**
     * get hostname
     *
     * @return mixed
     */
    public static function getHost()
    {
        return $_SERVER['HTTP_HOST'];
    }

    /**
     * get server port
     *
     * @return int
     */
    public static function getPort()
    {
        if (isset($_SERVER['SERVER_PORT'])) {
            return $_SERVER['SERVER_PORT'];
        }
        
        return \fly\constants\Constant::DEFAULT_SERVER_PORT;
    }

    /**
     * get query_string
     *
     * @return mixed
     */
    public static function getQueryString()
    {
        return $_SERVER['QUERY_STRING'];
    }

    /**
     * request method
     *
     * @return mixed
     */
    public static function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * get request_uri
     *
     * @return mixed
     */
    public static function getRequestUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * get full url
     *
     * @return string
     */
    public static function getFullUrl()
    {
        $protocol = self::getProtocol();
        $host = self::getHost();
        $uri = self::getRequestUri();
        
        $full_url = $protocol . '://' . $host . $uri;
        
        return $full_url;
    }

    /**
     * get url info array(
     * protocol => value
     * host => value
     * port => value
     * request_uri => value
     * query_string => value
     * full_url => value
     * )
     *
     * @return array
     */
    public static function getParseUrl()
    {
        $protocol = self::getProtocol();
        $host = self::getHost();
        $port = self::getPort();
        $uri = self::getRequestUri();
        $full_url = $protocol . '://' . $host . $uri;
        
        return array(
            'protocol' => $protocol,
            'host' => $host,
            'port' => $port,
            'request_uri' => $uri,
            'query_string' => self::getQueryString(),
            'full_url' => $full_url
        );
    }
}