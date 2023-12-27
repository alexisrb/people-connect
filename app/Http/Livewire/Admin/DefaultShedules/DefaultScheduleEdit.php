<?php

namespace App\Http\Livewire\Admin\DefaultShedules;

use App\Models\DefaultSchedule;
use App\Models\Schedule;
use Livewire\Component;

class DefaultScheduleEdit extends Component
{
    public $default_schedule;

    public $days = [];
    public $number_jornaulis;
    public $tipo_jornada, $tipo_horas;
    public $hora_entrada, $hora_salida, $day_entrada, $day_salida;

    public function mount(DefaultSchedule $default_schedule){
        $this->default_schedule = $default_schedule;
        $scheduleModel = Schedule::where('scheduleble_id', $default_schedule->id)->where('scheduleble_type', DefaultSchedule::class)->first();
        $scheduleData = json_decode($scheduleModel->schedule, true);
        $this->number_jornaulis = $scheduleModel->number_journaly;
        $this->tipo_jornada = $scheduleModel->tipo_jornada;
        $this->tipo_horas = $scheduleModel->tipo_horas;

        foreach ($scheduleData as $i => $jornada) {
            $this->day_entrada[$i] = $jornada['dia_entrada'];
            $this->hora_entrada[$i] = date('H:i', strtotime($jornada['hora_entrada']));
            $this->day_salida[$i] = $jornada['dia_salida'];
            $this->hora_salida[$i] = date('H:i', strtotime($jornada['hora_salida']));
        }
    }

    public function rules(){

        $array = [];

        //DefaultSchedule
        $array['default_schedule.nombre_del_horario'] = 'required|string|max:255';

        return $array;
    }

    public function save(){
        $this->validate();

        $where_not_in_schedule = Schedule::where('scheduleble_id', $this->default_schedule->id)->where('scheduleble_type', DefaultSchedule::class);

        $where_not_in_schedule->delete();

        $schedule = [];
        if(!empty($this->number_jornaulis)){
            for($i = 0; $i<$this->number_jornaulis; $i++){
                $nombreJornada = 'jornada'.($i + 1);
                $jornada = array(
                    'dia_entrada' => $this->day_entrada[$nombreJornada],
                    'hora_entrada' => $this->hora_entrada[$nombreJornada],
                    'dia_salida' => $this->day_salida[$nombreJornada],
                    'hora_salida' => $this->hora_salida[$nombreJornada],
                );
                $schedule["jornada" . ($i + 1)] =  $jornada;
            }
            Schedule::create([
                'tipo_jornada' => $this->tipo_jornada,
                'tipo_horas' => $this->tipo_horas,
                'number_journaly' => $this->number_jornaulis,
                'schedule' => json_encode($schedule),
                'scheduleble_id' => $this->default_schedule->id,
                'scheduleble_type' => DefaultSchedule::class,
                'actual' => true,
                'día' => null,
                'hora_de_entrada' => null,
                'hora_de_salida' => null,
                'turno' => null,
                'posición' => null,
            ]);
        }

        $this->default_schedule->save();

        session()->flash('message', 'Horario predeterminado editado satisfactoriamente.');
        return redirect(route('admin.default_schedules.index'));
    }

    public function render()
    {
        return view('livewire.admin.default-shedules.default-schedule-edit');
    }
}
