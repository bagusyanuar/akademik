<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $title;
    public $footer;

    /**
     * Create a new component instance.
     *
     * @param string $title
     * @param bool $footer
     */
    public function __construct($title = 'Card', $footer = false)
    {
        $this->title = $title;
        $this->footer = $footer;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.card');
    }
}
