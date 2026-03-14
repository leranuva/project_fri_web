<?php

namespace App\View\Components\App;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DashboardStats extends Component
{
    /**
     * Create a new component instance.
     * Componente específico de la aplicación para mostrar estadísticas del dashboard
     */
    public function __construct(
        public string $title = '',
        public string $value = '',
        public string $icon = '',
        public string $color = 'blue' // 'blue', 'green', 'red', 'yellow', 'purple'
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.app.dashboard-stats');
    }
}
