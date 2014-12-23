<?php namespace Nurmanhabib\Breadcrumb;

class Breadcrumb {

    /**
     * Kumpulan crumb yang akan diolah
     *
     * @var array
     */
    protected $crumbs;

    /**
     * Menyimpan crumb yang sedang aktif digunakan
     *
     * @var array
     */
    protected $current;

    public function __construct()
    {
        $this->crumbs = array();
        $this->current = array('name' => '', 'crumb' => new Crumb);
    }

    /**
     * Menginisialisasi sebuah crumb baru maupun memperbarui yang sudah ada
     *
     * @param string $name     Nama unik dari crumb
     * @param array  $list     Daftar link yang akan diolah
     * @param string $active   Link aktif
     * @param array  $disabled Link disabled
     */
    public function set($name, $list, $active = '', $disabled = array())
    {
        $crumb = new Crumb($list, $active, $disabled);

        $this->crumbs[$name]    = $crumb;
        $this->current          = array('name' => $name, 'crumb' => $crumb);

        return $crumb;
    }

    /**
     * Menginisialisasi sebuah crumb default
     *
     * @param array  $list     Daftar link yang akan diolah
     * @param string $active   Link aktif
     * @param array  $disabled Link disabled
     */
    public function setDefault($list, $active = '', $disabled = array())
    {
        return $this->set('default', $list, $active, $disabled);
    }

    /**
     * Menyisipkan link baru ke crumb
     *
     * @param  string $text Nama tampilan yang akan disisipi link
     * @param  string $url  Link yang dituju
     * @param  string $name Nama unik crumb yang akan disisipi
     *
     * @return Crumb
     */
    public function push($text, $url, $name = '')
    {
        $name   = !empty($name) ? $name : $this->current['name'];
        $crumb  = $this->name($name)->push($text, $url);

        $this->crumbs[$name] = $crumb;

        return $crumb;
    }

    /**
     * Mengambil crumb berdasarkan nama uniknya
     *
     * @param  string $name Nama dari crumb
     *
     * @return Crumb
     */
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