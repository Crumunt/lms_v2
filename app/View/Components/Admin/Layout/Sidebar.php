<?php

namespace App\View\Components\Admin\Layout;

use Illuminate\View\Component;
use Illuminate\View\View;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.admin.layout.sidebar');
    }
}