<?php

namespace App\Livewire;

use App\Models\Salario;
use Livewire\Component;
use App\Models\Categoria;
use App\Models\Vacante;
use Livewire\WithFileUploads;

class CrearVacante extends Component
{
    use WithFileUploads;

    public $titulo;
    public $salario;
    public $categoria;
    public $empresa;
    public $ultimo_dia;
    public $descripcion;
    public $imagen;

    public function crearVacante()
    {
        $validated = $this->validate([
            'titulo' => 'required|string',
            'salario' => 'required',
            'categoria' => 'required',
            'empresa' => 'required',
            'ultimo_dia' => 'required',
            'descripcion' => 'required',
            'imagen' => ['required', 'image', 'max:1024'],
        ]);

        // Almacenar la imagen
        $imagen = $this->imagen->store('vacantes', 'r2');
        $validated['imagen'] = str_replace('vacantes/', '', $imagen);

        // Crear la vacante
        Vacante::create([
            'titulo' => $validated['titulo'],
            'salario_id' => $validated['salario'],
            'categoria_id' => $validated['categoria'],
            'empresa' => $validated['empresa'],
            'ultimo_dia' => $validated['ultimo_dia'],
            'descripcion' => $validated['descripcion'],
            'imagen' => $validated['imagen'],
            'user_id' => auth()->user()->id
        ]);

        // Crear un mensaje
        session()->flash('mensaje', 'La Vacante se publicó correctamente');

        // Redireccionar al usuario
        return redirect()->route('vacantes.index');
    }

    public function render()
    {
        // Consulta la BD
        $salarios = Salario::all();
        $categorias = Categoria::all();

        return view('livewire.crear-vacante', [
            "salarios" => $salarios,
            "categorias" => $categorias
        ]);
    }
}
