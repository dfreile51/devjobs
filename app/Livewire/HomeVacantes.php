<?php

namespace App\Livewire;

use App\Models\Vacante;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class HomeVacantes extends Component
{
    use WithPagination;

    public $termino;
    public $categoria;
    public $salario;

    #[On('terminosBusqueda')]
    public function buscar($termino, $categoria, $salario)
    {
        $this->termino = $termino;
        $this->categoria = $categoria;
        $this->salario = $salario;

        $this->resetPage();
    }

    public function render()
    {
        // $vacantes = Vacante::all();
        $vacantes = Vacante::when($this->termino, function ($query) {
            $query->where('titulo', 'LIKE', "%" . $this->termino . "%");
        })->when($this->termino, function ($query) {
            $query->orWhere('empresa', 'LIKE', "%" . $this->termino . "%");
        })->when($this->categoria, function ($query) {
            if ($this->categoria !== "-- Seleccione --") {
                $query->where('categoria_id', $this->categoria);
            }
        })->when($this->salario, function ($query) {
            if ($this->salario !== "-- Seleccione --") {
                $query->where('salario_id', $this->salario);
            }
        })->paginate(20);

        return view('livewire.home-vacantes', [
            'vacantes' => $vacantes
        ]);
    }
}
