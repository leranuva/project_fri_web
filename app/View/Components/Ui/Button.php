<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $variant = 'primary', // 'primary', 'secondary', 'danger', 'success', 'outline'
        public string $size = 'default', // 'sm', 'default', 'lg'
        public bool $fullWidth = false, // Mobile-first: full width en móvil, auto en desktop
        public string $type = 'button'
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.button');
    }
}
