<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Input extends Component
{
    public $id;
    public $name;
    public $label;
    public $type;

    /**
     * Create a new component instance.
     *
     * @param $id
     * @param $name
     * @param string $type
     * @param string $label
     */
    public function __construct($id, $name, $type = 'text', $label = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.input');
    }
}
