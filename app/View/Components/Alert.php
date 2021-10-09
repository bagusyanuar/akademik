<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $title;
    public $description;

    /**
     * Create a new component instance.
     *
     * @param string $title
     * @param string $description
     */
    public function __construct($title = 'Alert', $description ='')
    {
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.alert');
    }
}
