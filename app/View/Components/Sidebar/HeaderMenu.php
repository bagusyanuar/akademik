<?php

namespace App\View\Components\Sidebar;

use Illuminate\View\Component;

class HeaderMenu extends Component
{
    public $title;

    /**
     * Create a new component instance.
     *
     * @param string $title
     */
    public function __construct($title = 'Header Menu')
    {
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sidebar.header-menu');
    }
}
