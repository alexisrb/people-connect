<?php

namespace App\Http\Livewire\Admin\ExtraOrdinariesHours;

use App\Models\ExtraordinaryOvertime;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ExtraOrdinariesCreate extends Component
{
      public $schedule = [];
      public $number_jornaulis, $user, $users_boss, $fecha_hora, $journalis_estatus, $hours;

      use WithPagination;

      public function rules(){
            $array = [];
            $array['hours'] = 'required';
            $array['fecha_hora'] = 'required';

            return $array;
      }

      public function save(){
            $this->validate();

            $extraordinary_overtime = ExtraordinaryOvertime::create([
                  'hours' => $this->hours,
                  'fecha_hora' => $this->fecha_hora,
                  'user_id' => $this->user,
                  'approval_jefe_id' => auth()->user()->id,
                  'estatus' => $this->journalis_estatus,
                  'creador_id' => auth()->user()->id
            ]);

            session()->flash('message', 'Hora extraordinaria creada satisfactoriamente.');

            return redirect(route('admin.extraordinary.index'));
      }
      
      public function render()
      {
            $users = User::where('estatus', 'Activo')->orderBy('name')->get();
            return view('livewire.admin.extraordinaries_overtimes.extraordinaries-create', [
                  'users' => $users
            ]);
      }
}