<?php namespace Nurmanhabib\Breadcrumb;

class Breadcrumb {

    public $class           = 'breadcrumb';
    public $class_active    = 'active';
    public $lists           = array();

    public function add($text = array(), $link = '')
    {
        if(is_array($text))
        {
            $this->lists    += $text;
        }
        else
        {
            $this->lists    += array($text => $link);
        }

        return $this;
    }

    public function pop()
    {
        array_pop($this->lists);

        return $this;
    }

    public function generate()
    {
        $html   = '<ul class="' . self::$class . '">';
        $keys   = array_keys(self::$list);
        $last   = end($keys);

        foreach (self::$list as $text => $link)
        {
            if($link != '' && $text != $last)
            {
                $html   .= '<li>';
                $html   .= '<a href="' . $link . '">' . $text . '</a>';
            }
            else
            {
                $html   .= '<li class="' . self::$class_active . '">';  
                $html   .= '<span>' . $text . '</span>';
            }
            
            $html   .= '</li>';
        }

        $html   .= '</ul>';

        return $html;
    }

    public function links()
    {
        return $this->generate();
    }

}