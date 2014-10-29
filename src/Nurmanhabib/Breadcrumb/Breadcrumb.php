<?php namespace Nurmanhabib\Breadcrumb;

class Breadcrumb {

    protected $crumbs;

    protected $current;

    public function __construct()
    {
        $this->crumbs = array();
        $this->current = array('name' => '', 'crumb' => new Crumb);
    }

    public function set($name, $list, $active = '', $disabled = array())
    {
        $crumb = new Crumb($list, $active, $disabled);

        $this->crumbs[$name]    = $crumb;
        $this->current          = array('name' => $name, 'crumb' => $crumb);

        return $crumb;
    }

    public function setDefault($list, $active = '', $disabled = array())
    {
        return $this->set('default', $list, $active, $disabled);
    }

    public function push($text, $url, $name = '')
    {
        $name = !empty($name) ?: $this->current['name'];
        
        $this->crumbs[$name] += array($text => $url);

        return $this;
    }

    public function name($name)
    {
        if (array_key_exists($name, $this->crumbs)) {
            $crumb          = $this->crumbs[$name];
            $this->current  = array('name' => $name, 'crumb' => $crumb);
            
            return $crumb;
        }
        else
            return new Crumb;
    }

    public function __set($name, Crumb $crumb)
    {
        $this->crumbs[$name]    = $crumb;
        $this->current          = array('name' => $name, 'crumb' => $crumb);
    }

    public function __get($name)
    {
        $crumb = array_key_exists($name, $this->crumbs) ? $this->crumbs[$name] : new Crumb;
        
        return $crumb;
    }

    public function __toString()
    {
        return (string) $this->current['crumb'];
    }

}