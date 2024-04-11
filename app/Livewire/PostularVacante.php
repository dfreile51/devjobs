<?php

namespace App\Livewire;

use App\Models\Vacante;
use App\Notifications\NuevoCandidato;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostularVacante extends Component
{
    use WithFileUploads;

    public $cv;
    public $vacante;

    public function mount(Vacante $vacante)
    {
        $this->vacante = $vacante;
    }

    public function postularme()
    {
        $validated = $this->validate([
            'cv' => ['required', 'mimes:pdf'],
        ]);

        if (auth()->user()->id === $this->vacante->reclutador->id) {
            session()->flash('error', 'No puedes postularte a una vacante que tu mismo publicaste');
            return;
        }

        if ($this->vacante->candidatos()->where('user_id', auth()->user()->id)->count() > 0) {
            session()->flash('error', 'Ya postulaste a esta vacante anteriormente');
            return;
        }

        // Almacenar CV en el disco duro
        $cv = $this->cv->store('cv', 'r2');
        $validated['cv'] = str_replace('cv/', '', $cv);

        // Crear el candidato a la vacante
        $this->vacante->candidatos()->create([
            'user_id' => auth()->user()->id,
            'cv' => $validated['cv']
        ]);

        // Crear notificacion y enviar el email
        $this->vacante->reclutador->notify(new NuevoCandidato($this->vacante->id, $this->vacante->titulo, auth()->user()->id));

        // Mostrar al usuario un mensaje de ok
        session()->flash('mensaje', 'Se envió correctamente tu información, mucha suerte');

        return redirect()->back();
    }

    public function render()
    {
        return view('livewire.postular-vacante');
    }
}
