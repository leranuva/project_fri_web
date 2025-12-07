<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     * Mobile-first: Oculto en móvil, visible en lg (1024px+)
     */
    public function __construct(
        public string $position = 'left', // 'left', 'right'
        public int $width = 64 // Ancho en unidades Tailwind (16 = 4rem = 64px)
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.sidebar');
    }
}
