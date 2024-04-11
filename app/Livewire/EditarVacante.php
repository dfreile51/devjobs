<?php

namespace App\Livewire;

use App\Models\Salario;
use App\Models\Vacante;
use Livewire\Component;
use App\Models\Categoria;
use Illuminate\Support\Carbon;
use Livewire\WithFileUploads;

class EditarVacante extends Component
{
    use WithFileUploads;

    public $vacante_id;
    public $titulo;
    public $salario;
    public $categoria;
    public $empresa;
    public $ultimo_dia;
    public $descripcion;
    public $imagen;
    public $imagen_nueva;

    public function mount(Vacante $vacante)
    {
        $this->vacante_id = $vacante->id;
        $this->titulo = $vacante->titulo;
        $this->salario = $vacante->salario_id;
        $this->categoria = $vacante->categoria_id;
        $this->empresa = $vacante->empresa;
        $this->ultimo_dia = Carbon::parse($vacante->ultimo_dia)->format('Y-m-d');
        $this->descripcion = $vacante->descripcion;
        $this->imagen = $vacante->imagen;
    }

    public function editarVacante()
    {
        $validated = $this->validate([
            'titulo' => 'required|string',
            'salario' => 'required',
            'categoria' => 'required',
            'empresa' => 'required',
            'ultimo_dia' => 'required',
            'descripcion' => 'required',
            'imagen_nueva' => ['nullable', 'image', 'max:1024'],
        ]);

        // Encontrar la vacante a editar
        $vacante = Vacante::find($this->vacante_id);

        // Si hay una nueva imagen
        if ($this->imagen_nueva) {
            $imagen = $this->imagen_nueva->store(path: 'public/vacantes');
            $validated['imagen'] = str_replace('public/vacantes/', "", $imagen);
            unlink(storage_path('app/public/vacantes') . '/' . $vacante->imagen);
        }

        // Asignar los valores
        $vacante->titulo = $validated['titulo'];
        $vacante->salario_id = $validated['salario'];
        $vacante->categoria_id = $validated['categoria'];
        $vacante->empresa = $validated['empresa'];
        $vacante->ultimo_dia = $validated['ultimo_dia'];
        $vacante->descripcion = $validated['descripcion'];
        $vacante->imagen = $validated['imagen'] ?? $vacante->imagen;

        // Guardar la vacante
        $vacante->save();

        // Redireccionar
        session()->flash('mensaje', 'La Vacante se actualizó Correctamente');

        return redirect()->route('vacantes.index');
    }

    public function render()
    {
        // Consulta la BD
        $salarios = Salario::all();
        $categorias = Categoria::all();

        return view('livewire.editar-vacante', [
            "salarios" => $salarios,
            "categorias" => $categorias
        ]);
    }
}
