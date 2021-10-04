<?php

namespace App\View\Components\Sidebar;

use Illuminate\View\Component;

class Item extends Component
{
    public $title;

    public $link;
    public $icon;

    /**
     * Create a new component instance.
     *
     * @param string $link
     * @param string $title
     * @param string $icon
     */
    public function __construct($link = '/', $title = 'Menu', $icon = 'fa fa-circle-o')
    {
        $this->link = $link;
        $this->title = $title;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sidebar.item');
    }
}
