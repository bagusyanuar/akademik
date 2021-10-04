<?php

namespace App\View\Components\Navbar;

use Illuminate\View\Component;

class LeftNavbar extends Component
{
    public $isPushMenu;

    /**
     * Create a new component instance.
     *
     * @param bool $isPushMenu
     */
    public function __construct($isPushMenu = true)
    {
        $this->isPushMenu = $isPushMenu;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.navbar.left-navbar');
    }
}
