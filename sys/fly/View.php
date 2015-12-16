<?php
namespace fly\fly;

abstract class View {
    /**
     * @var String
     */
    protected $pageName;

    private $_page_ext = '.php';

    public function render(){
        $this->setPageName();

        if (empty($this->pageName)) {
            return false;
        }

        $page_file = APP_PATH . 'pages' . DS . $this->pageName . $this->_page_ext;

        if (!file_exists($page_file)) {
            return false;
        }

        $attributes = \Fly::getInstance()->getAttributes();

        if (!empty($attributes)) {
            foreach ($attributes as $key => $value) {
                $$key = $value;
            }
        }

        include $page_file;

        return true;
    }

    public function getPageName(){
        return $this->pageName;
    }

    abstract function setPageName();

    abstract function getTitle();

    abstract function getDescription();

    abstract function getMeta();
}