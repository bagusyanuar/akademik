<?php

namespace App\View\Components\Sidebar;

use Illuminate\View\Component;

class Brand extends Component
{

    public $link;

    public $image;

    /**
     * Create a new component instance.
     *
     * @param $link
     * @param string $image
     */
    public function __construct($link = '/', $image = 'https://adminlte.io/themes/dev/AdminLTE/dist/img/AdminLTELogo.png')
    {
        $this->link = $link;
        $this->image = $image;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sidebar.brand');
    }
}
