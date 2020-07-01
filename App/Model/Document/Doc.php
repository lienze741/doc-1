<?php


namespace App\Model\Document;


class Doc
{
    protected $name = 'default';

    protected $template;

    protected $rootPath;

    function __construct(string $rootPath)
    {
        $this->rootPath = $rootPath;
        $this->template = new Template();
    }

    /**
     * @return Template
     */
    public function getTemplate(): Template
    {
        return $this->template;
    }

    function displayHomePage(?Args $args = null):?string
    {
        return $this->render($this->template->getHomePageTpl(),$args);
    }

    function displayContentPage(string $mdFile,?Args $args = null):?string
    {
        return $this->render($mdFile,$args);
    }

    function displayPageNotFound(?Args $args = null):?string
    {
        return $this->render($this->template->getPageNotFoundTpl(),$args);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    protected function render(string $file,?Args $args = null)
    {
        if(!$args){
            $args = new Args();
        }
        $file = $this->rootPath.$file;
        if(!file_exists($file)){
            return null;
        }
        $args->setArg("DOC_NAME",$this->name);
        return file_get_contents($file);
    }
}