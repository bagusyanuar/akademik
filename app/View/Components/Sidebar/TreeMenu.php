<?php

namespace App\View\Components\Sidebar;

use Illuminate\View\Component;

class TreeMenu extends Component
{
    public $title;

    public $icon;

    public $children;

    /**
     * Create a new component instance.
     *
     * @param string $title
     * @param array $children
     * @param string $icon
     */
    public function __construct($title = 'Tree Menu', $children = [], $icon = 'fa fa-circle-o')
    {
        $this->title = $title;
        $this->children = $children;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sidebar.tree-menu');
    }
}
