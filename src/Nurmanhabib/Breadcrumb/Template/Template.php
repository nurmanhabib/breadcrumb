<?php namespace Nurmanhabib\Breadcrumb\Template;

use Nurmanhabib\Breadcrumb\Crumb;
use View;

class Template {

    protected $crumb;

    protected $view;

    public function __construct(Crumb $crumb, $view = null)
    {
        $this->crumb = $crumb;
        
        if (!empty($view))
            $this->view = $view;
    }

    public function getItem($text, $url)
    {
        return '<li><a href="'.$url.'">'.$text.'</a></li>';
    }

    public function getDisabledItem($text, $url)
    {
        return '<li class="disabled">'.$text.'</li>';
    }

    public function getActiveItem($text, $url)
    {
        return '<li class="active">'.$text.'</li>';
    }

    public function setView($name = null)
    {
        if (!empty($name))
            $this->view = $name;

        return $this;
    }

    public function checkActive(Crumb $crumb, $active = '')
    {
        if (!empty($active))
            $crumb->active = $active;            

        foreach ($crumb->list as $text => $url)
            if ($crumb->active == $url)
                return true;
                return false;
    }

    public function render()
    {
        return View::make($this->view, ['crumb' => $this->crumb, 'list' => $this->renderList()]);
    }

    public function renderList()
    {
        $html = '';

        foreach ($this->crumb->list as $text => $url) {

            if ($this->crumb->active == $url)
                $html .= $this->getActiveItem($text, $url);
            else
                $html .= $this->getItem($text, $url);

        }

        return $html;
    }

}