<?php namespace Nurmanhabib\Breadcrumb;

use Config;

class Crumb {

    public $list;

    public $active;

    public $disabled;

    public $template;

    public $view;

    public function __construct($list = array(), $active = '', $disabled = array())
    {
        $this->initialize($list, $active, $disabled);
    }

    public function initialize($list = array(), $active = '', $disabled = array())
    {        
        $this->list     = $list;
        $this->active   = $active;
        $this->disabled = $disabled;

        $config         = Config::get('breadcrumb::config');

        $this->setTemplate($config['template']);
    }

    public function setTemplate($name)
    {
        $template_alias     = Config::get('breadcrumb::template');
        $template_class     = $template_alias[$name];

        $this->template     = new $template_class($this);

        return $this;
    }

    public function setTemplateClass($class)
    {
        $this->template     = new $class($this);

        return $this;
    }

    public function setView($name)
    {
        $this->view = $name;

        return $this;
    }

    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    public function push($text, $link = '')
    {
        if (is_array($text))
            $this->list += $text;
        else
            $this->list += array($text => $link);

        return $this;
    }

    public function setDisabled($disabled = array())
    {
        if (!is_array($disabled))
            $disabled = array($disabled);

        $this->disabled = $disabled;

        return $this;
    }

    public function links($view = null)
    {
        if (!empty($view))
            $this->view = $view;

        $template_name = Config::get('breadcrumb::config.template');
        $template_class = Config::get('breadcrumb::template.'.$template_name);
        
        $template = new $template_class($this, $this->view);

        return $this->template->setView($this->view)->render();
    }

    public function __toString()
    {
        return (string) $this->links();
    }

}