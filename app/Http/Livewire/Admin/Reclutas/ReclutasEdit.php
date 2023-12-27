<?php

namespace App\Http\Livewire\Admin\Reclutas;
use App\Models\Area;
use App\Models\Company;
use App\Models\CostCenter;
use App\Models\DefaultSchedule;
use App\Models\Image;
use App\Models\Schedule;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;
class ReclutasEdit extends Component
{
    use WithFileUploads;

    public $user, $document;

     //HORARIO
     public $days = [];
     public $hora_de_entrada, $hora_de_salida;
 
     public $horario;
 
     public $number_jornaulis;
     public $hora_entrada, $hora_salida, $day_entrada, $day_salida;
     //HORARIO PREDETERMINADO
     public $horario_predeterminado;

    //User
    public $foto, $qr, $name, $email, $curp, $company, $puesto, $tipo_de_puesto, $tipo;

    public $documento_de_identificación_oficial, $documento_del_comprobante_de_domicilio, $documento_de_no_antecedentes_penales,
        $documento_de_la_licencia_de_conducir , $documento_de_la_cedula_profesional, $documento_de_la_carta_de_pasante, $documento_del_curriculum_vitae, $documento_del_requisicion_firmada, $documento_del_curp, $documento_de_caratula_bancaria, $documento_de_cedula_fiscal, $documento_del_acta_de_nacimiento, $documento_del_seguro_social, $otros_documentos;
    
    public function mount(User $user){
        $this->user = $user;
        $this->document = $user->document;
    
        $this->qr = $user->qr;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->curp = $user->curp;
        $this->tipo_de_puesto = $this->user->tipo_de_puesto;
        $this->company = $user->company_id;
        $this->tipo = $user->tipo;

        $schedules = Schedule::where('scheduleble_id', $user->id)->where('scheduleble_type', User::class)->orderBy('posición', 'asc');
        $scheduleData = $schedules->first();
        if($scheduleData != null){
            if( $scheduleData->schedule == null){
                $this->days = $schedules->pluck('día')->toArray();
    
                foreach($schedules->get() as $i => $day){
                    $this->hora_de_entrada[$i] = $day->hora_de_entrada->format('H:i');
                    $this->hora_de_salida[$i] = $day->hora_de_salida->format('H:i');
                }
            }else{
                $scheduleModel = Schedule::where('scheduleble_id', $user->id)->where('scheduleble_type', User::class)->first();
                if($scheduleModel){
                    $scheduleData = json_decode($scheduleModel->schedule, true);
                    $this->number_jornaulis = $scheduleModel->number_journaly;
                    foreach ($scheduleData as $i => $jornada) {
                        $this->day_entrada[$i] = $jornada['dia_entrada'];
                        $this->hora_entrada[$i] = date('H:i', strtotime($jornada['hora_entrada']));
                        $this->day_salida[$i] = $jornada['dia_salida'];
                        $this->hora_salida[$i] = date('H:i', strtotime($jornada['hora_salida']));
                    }
                }
            }
        }
    }

    public function updatedhorariopredeterminado($horario_predeterminado){
        if($horario_predeterminado != ""){
            $default_schedule = DefaultSchedule::where('id', $horario_predeterminado)->first();

            $scheduleModel = Schedule::where('scheduleble_id', $default_schedule->id)->where('scheduleble_type', DefaultSchedule::class)->first();
            $scheduleData = json_decode($scheduleModel->schedule, true);

            $this->number_jornaulis = $scheduleModel->number_journaly;
            // $this->days = $schedules->pluck('día')->toArray();
            foreach ($scheduleData as $i => $jornada) {
                $this->day_entrada[$i] = $jornada['dia_entrada'];
                $this->hora_entrada[$i] = date('H:i', strtotime($jornada['hora_entrada']));
                $this->day_salida[$i] = $jornada['dia_salida'];
                $this->hora_salida[$i] = date('H:i', strtotime($jornada['hora_salida']));
            }
        }else{
            $this->number_jornaulis = 0;
            $this->day_entrada = [];
            $this->hora_entrada = [];
            $this->day_salida = [];
            $this->hora_salida = [];
        }
    }

    public function rules(){
        
        $array = [];

        //User
        $array['foto'] = 'nullable|image|mimes:jpeg,jpg,png|max:5048';
        $array['user.name'] = 'required|string|max:255';
        $array['curp'] = ['required', 'string', 'min:18', 'max:18'/*, 'regex:/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/'*/, 'unique:users,curp,'.$this->user->id];
        $array['email'] = ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$this->user->id];
        $array['user.número_de_inscripción_al_imss'] = 'nullable|string|max:255';
        $array['user.rfc'] = ['required',/* 'regex:/^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/',*/'string','max:255'];
        $array['user.número_del_infonavit'] = 'nullable|string|max:255';

        //Work
        $array['user.puesto'] = 'nullable|string|max:255';
        $array['tipo_de_puesto'] = 'nullable|string|max:255';
        $array['company'] = ['required'];
        $array['tipo'] = ['required'];


        //Horario
        $array['days'] = "nullable";

        //Docs
        $array['documento_de_identificación_oficial'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_del_comprobante_de_domicilio'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_de_no_antecedentes_penales'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_de_la_licencia_de_conducir'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_de_la_cedula_profesional'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_de_la_carta_de_pasante'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_del_curriculum_vitae'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_de_caratula_bancaria'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_de_cedula_fiscal'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_del_curp'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_del_requisicion_firmada'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_del_acta_de_nacimiento'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_del_seguro_social'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['otros_documentos'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        return $array;
    }

    protected $messages = [
        'tipo.required' => 'El campo estatus es requerido.'
    ];

    public function updatedemail($email){
        $this->qr = 'email='.$this->email.'&curp='.$this->curp;
    }

    public function updatedcurp($curp){
        $this->qr = 'email='.$this->email.'&curp='.$this->curp;
    }

    public function save(){

        $this->validate();

        if($this->foto){
            if($this->user->image){
                //Si el usuario tiene imagen elimina y actualiza
                Storage::delete($this->user->image->url); //Elimino

                $this->user->image->update([ //Actualizo
                    'url' => $this->foto->storeAs("fotos", $this->foto->store('fotos'), "private"), //Guardo
                ]);
            }else{
                //Si el usuario no tiene imagen, cree una
                Image::create([
                    'url' => $this->foto->storeAs("fotos", $this->foto->store('fotos'), "private"),
                    'imageable_id' => $this->user->id,
                    'imageable_type' => 'App\Models\User'
                ]);
            }

        }

        //Docs
        if($this->documento_de_identificación_oficial){
            Storage::delete([$this->document->documento_de_identificación_oficial]);
            $this->document->documento_de_identificación_oficial = $this->documento_de_identificación_oficial->store('identificaciones_oficiales');
        }

        if($this->documento_del_comprobante_de_domicilio){
            Storage::delete([$this->document->documento_del_comprobante_de_domicilio]);
            $this->document->documento_del_comprobante_de_domicilio = $this->documento_del_comprobante_de_domicilio->store('comprobantes_de_domicilio');
        }

        if($this->documento_de_no_antecedentes_penales){
            Storage::delete([$this->document->documento_de_no_antecedentes_penales]);
            $this->document->documento_de_no_antecedentes_penales = $this->documento_de_no_antecedentes_penales->store('documentos_de_no_antecedentes_penales');
        }

        if($this->documento_de_la_licencia_de_conducir){
            Storage::delete([$this->document->documento_de_la_licencia_de_conducir]);
            $this->document->documento_de_la_licencia_de_conducir = $this->documento_de_la_licencia_de_conducir->store('licencias_de_conducir');
        }

        if($this->documento_de_la_cedula_profesional){
            Storage::delete([$this->document->documento_de_la_cedula_profesional]);
            $this->document->documento_de_la_cedula_profesional = $this->documento_de_la_cedula_profesional->store('cedulas_profesionales');
        }

        if($this->documento_de_la_carta_de_pasante){
            Storage::delete([$this->document->documento_de_la_carta_de_pasante]);
            $this->document->documento_de_la_carta_de_pasante = $this->documento_de_la_carta_de_pasante->store('cartas_de_pasantes');
        }

        if($this->documento_del_curriculum_vitae){
            Storage::delete([$this->document->documento_del_curriculum_vitae]);
            $this->document->documento_del_curriculum_vitae = $this->documento_del_curriculum_vitae->store('curriculums_vitaes');
        }

        if($this->documento_de_caratula_bancaria){
            Storage::delete([$this->document->documento_de_caratula_bancaria]);
            $this->document->documento_de_caratula_bancaria = $this->documento_de_caratula_bancaria->store('caratula_bancaria');
        }
        

        if($this->documento_de_cedula_fiscal){
            Storage::delete([$this->document->documento_de_cedula_fiscal]);
            $this->document->documento_de_cedula_fiscal = $this->documento_de_cedula_fiscal->store('cedula_fiscal');
        }

        if($this->documento_del_curp){
            Storage::delete([$this->document->documento_del_curp]);
            $this->document->documento_del_curp = $this->documento_del_curp->store('curp');
        }

        if($this->documento_del_requisicion_firmada){
            Storage::delete([$this->document->documento_del_requisicion_firmada]);
            $this->document->documento_del_requisicion_firmada = $this->documento_del_requisicion_firmada->store('requisicion_firmada');
        }

        if($this->documento_del_acta_de_nacimiento){
            Storage::delete([$this->document->documento_del_acta_de_nacimiento]);
            $this->document->documento_del_acta_de_nacimiento = $this->documento_del_acta_de_nacimiento->store('acta_nacimiento');
        }

        if($this->documento_del_seguro_social){
            Storage::delete([$this->document->documento_del_seguro_social]);
            $this->document->documento_del_seguro_social = $this->documento_del_seguro_social->store('seguro_social');
        }
        
        if($this->otros_documentos){
            Storage::delete([$this->document->otros_documentos]);
            $this->document->otros_documentos = $this->otros_documentos->store('otros_documentos');
        }
        

        $this->user->qr = $this->qr;
        $this->user->email = $this->email;
        $this->user->curp = $this->curp;
        $this->user->password = Hash::make(mb_strtoupper($this->curp, 'UTF-8'));
        $this->user->tipo_de_puesto = $this->tipo_de_puesto;
        $this->user->company_id = $this->company;
        $this->user->tipo = $this->tipo;

        $this->user->save();
        $this->document->save();

        //Actualizar horario
        $where_not_in_schedule = Schedule::where('scheduleble_id', $this->user->id)->where('scheduleble_type', User::class);

        $where_not_in_schedule->delete();
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
                'tipo_jornada' => null,
                'tipo_horas' => null,
                'number_journaly' => $this->number_jornaulis,
                'schedule' => json_encode($schedule),
                'scheduleble_id' => $this->user->id,
                'scheduleble_type' => User::class,
                'actual' => true,
                'día' => null,
                'hora_de_entrada' => null,
                'hora_de_salida' => null,
                'turno' => null,
                'posición' => null
            ]);
        }

        session()->flash('message', 'Reclutado se editó satisfactoriamente.');

        return redirect(route('admin.reclutas.index'));
    }

    public function render()
    {
        $companies = Company::orderBy('nombre_de_la_compañia')->get();
        $default_schedules = DefaultSchedule::orderBy('nombre_del_horario')->get();
        return view('livewire.admin.reclutas.reclutas-edit', [
            'companies' => $companies,
            'default_schedules' => $default_schedules
        ]);
    }
}
