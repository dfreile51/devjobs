<?php

namespace App\Livewire;

use App\Models\Vacante;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class MostrarVacantes extends Component
{
    use WithPagination;

    // #[On('prueba')]
    // public function prueba($vacante_id)
    // {
    //     dd($vacante_id);
    // }

    #[On('eliminarVacante')]
    public function eliminarVacante(Vacante $vacante)
    {
        $vacante->delete();
    }

    public function render()
    {
        $vacantes = Vacante::where('user_id', auth()->user()->id)->paginate(10);

        return view('livewire.mostrar-vacantes', [
            'vacantes' => $vacantes
        ]);
    }
}
