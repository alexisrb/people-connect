<?php

namespace App\Http\Livewire\Admin\Vacations;

use App\Models\User;
use App\Models\Vacation;
use Livewire\Component;

class VacationsCreate extends Component
{
    public $user, $motivo, $fecha_inicial, $fecha_final, $tipo;

    public function rules(){
        
        $array = [];
        
        $array['user'] = 'required';
        $array['tipo'] = 'required';
        $array['motivo'] = ['required', 'string', 'max:255'];
        $array['fecha_inicial'] = 'required|date';
        $array['fecha_final'] = 'required|date';

        return $array;
    }

    public function save(){

        $this->validate();

        Vacation::create([
            'motivo' => $this->motivo,
            'tipo' => $this->tipo,
            'fecha_inicial' => $this->fecha_inicial,
            'fecha_final' => $this->fecha_final,
            'user_id' => $this->user,
            'estatus' => 'En espera'
        ]);

        session()->flash('message', 'Solicitud de vacaciones creado satisfactoriamente.');

        return redirect(route('admin.vacations.index'));
    }

    public function render()
    {
        $users = User::orderBy('name')->get();

        return view('livewire.admin.vacations.vacations-create', [
            'users' => $users
        ]);
    }
}
