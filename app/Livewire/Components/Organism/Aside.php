<?php

namespace App\Livewire\Components\Organism;

use Illuminate\Support\Facades\Route;
use Livewire\Attributes\On;
use Livewire\Component;

class Aside extends Component
{
    public $menu;
    public $first = true;
    public $hide = false;

    public function mount()
    {
        $currentRoute = Route::currentRouteName();

        $this->menu = collect(config('general.menu'))->map(function ($item) use ($currentRoute) {
            if (isset($item['dropdown'])) {
                $item['isExpanded'] = false; // Inicializa todos los dropdowns como no expandidos por defecto

                // Verifica si la ruta actual coincide con alguna ruta de los subelementos del dropdown
                foreach ($item['dropdown'] as $subItem) {
                    if ($subItem['route'] === $currentRoute) {
                        $item['isExpanded'] = true; // Marca como expandido el dropdown cuya ruta coincida
                        break; // Rompe el bucle una vez que se haya encontrado una coincidencia
                    }
                }
            }

            return $item;
        })->toArray();
    }

    public function toggleDropdown($index)
    {
        $this->menu[$index]['isExpanded'] = !$this->menu[$index]['isExpanded'];
    }

    public function isActiveSubmenu($submenu)
    {
        foreach ($submenu as $subItem) {
            if (Route::currentRouteName() === $subItem['route']) {
                return true;
            }
        }
        return false;
    }

    #[On('hideLinksAside')]
    public function hideLinksAside()
    {
        $this->first = false;
        $this->hide = !$this->hide;
    }

    public function render()
    {
        return view('livewire.components.organism.aside');
    }
}
