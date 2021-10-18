<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Textarea extends Component
{
    public $id;
    public $name;
    public $label;

    /**
     * Create a new component instance.
     *
     * @param $id
     * @param $name
     * @param string $label
     */
    public function __construct($id, $name, $label = '')
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
        return view('components.form.textarea');
    }
}
