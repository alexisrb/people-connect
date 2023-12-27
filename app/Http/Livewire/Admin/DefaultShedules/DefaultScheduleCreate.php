<?php

namespace App\Http\Livewire\Admin\DefaultShedules;

use App\Models\DefaultSchedule;
use App\Models\Schedule;
use Livewire\Component;

class DefaultScheduleCreate extends Component
{
    public $nombre_del_horario;

    public $days = [];
    public $días_de_trabajo_a_la_semana, $hora_de_entrada, $hora_de_salida, $tipo_jornada, $tipo_horas;
    public $number_jornaulis ;
    public $hora_entrada, $hora_salida, $day_entrada, $day_salida;

    public function rules(){

        $array = [];
        $array['nombre_del_horario'] = 'required|string|max:255';

        return $array;
    }

    public function save(){

        $this->validate();

        $default_schedule = DefaultSchedule::create([
            'nombre_del_horario' => $this->nombre_del_horario
        ]);

        $schedule = [];
        if(!empty($this->number_jornaulis)){
            for($i = 0; $i<$this->number_jornaulis; $i++){
                $jornada = array(
                    'dia_entrada' => $this->day_entrada[$i],
                    'hora_entrada' => $this->hora_entrada[$i],
                    'dia_salida' => $this->day_salida[$i],
                    'hora_salida' => $this->hora_salida[$i],
                );
                $schedule["jornada" . ($i + 1)] =  $jornada;
            }
            Schedule::create([
                'tipo_jornada' => $this->tipo_jornada,
                'tipo_horas' => $this->tipo_horas,
                'number_journaly' => $this->number_jornaulis,
                'schedule' => json_encode($schedule),
                'scheduleble_id' => $default_schedule->id,
                'scheduleble_type' => DefaultSchedule::class,
                'actual' => true,
                'día' => null,
                'hora_de_entrada' => null,
                'hora_de_salida' => null,
                'turno' => null,
                'posición' => null,
            ]);
        }

        session()->flash('message', 'Horario predeterminado creado satisfactoriamente.');
        return redirect(route('admin.default_schedules.index'));
    }

    public function render()
    {
        return view('livewire.admin.default-shedules.default-schedule-create');
    }
}
