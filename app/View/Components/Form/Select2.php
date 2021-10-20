<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Select2 extends Component
{
    public $id;
    public $label;
    public $name;

    /**
     * Create a new component instance.
     *
     * @param $name
     * @param $id
     * @param string $label
     */
    public function __construct($name, $id, $label = 'Select')
    {
        $this->id = $id;
        $this->name = $name;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.select2');
    }
}
