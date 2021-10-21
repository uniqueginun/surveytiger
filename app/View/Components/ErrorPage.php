<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ErrorPage extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public int $code, public string $message) { }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.error-page');
    }
}
