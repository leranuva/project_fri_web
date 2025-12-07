<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Grid extends Component
{
    /**
     * Create a new component instance.
     * Rejilla responsiva: 1 columna en móvil, 2 en sm (640px+), 3 en md (768px+)
     */
    public function __construct(
        public int $cols = 1,      // Columnas en móvil (base)
        public int $colsSm = 2,    // Columnas en sm (640px+)
        public int $colsMd = 3,     // Columnas en md (768px+)
        public string $gap = 'default' // 'none', 'sm', 'default', 'lg'
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.grid');
    }
}
