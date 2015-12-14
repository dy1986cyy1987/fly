<?php
namespace fly\utils;

class Import
{

    /**
     *
     * @var \fly\utils\Import
     */
    private static $instance;

    private $_file_container = array();

    private function __construct()
    {}

    private function __clone()
    {}

    /**
     *
     * @return \fly\utils\Import
     */
    public static function getInstance()
    {
        if (! self::$instance) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }

    /**
     *
     * @param string $fileName            
     * @return NULL|mixed
     */
    public function importFile($fileName = '')
    {
        if (! $fileName || ! file_exists($fileName)) {
            return null;
        }
        
        $key = md5($fileName);
        
        if (! isset($this->_file_container[$key])) {
            $this->_file_container[$key] = require $fileName;
        }
        
        return $this->_file_container[$key];
    }
}