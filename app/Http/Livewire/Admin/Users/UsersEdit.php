<?php

namespace App\Http\Livewire\Admin\Users;

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

class UsersEdit extends Component
{
    use WithFileUploads;

    public $user, $document;

    //User
    public $foto, $qr, $name, $email, $curp, $fecha_de_nacimiento, $código_del_país, $número_de_teléfono, $número_de_empleado, $fecha_de_ingreso, $company, $cost_centers, $cost_center, $área, $encargado, $puesto, $tipo_de_puesto, $tipo, $derecho_a_hora_extra, $recontratable, $estatus, $password, $password_confirmation, $role, $rh;

    public $documento_de_identificación_oficial, $documento_del_comprobante_de_domicilio, $documento_de_no_antecedentes_penales,
        $documento_de_la_licencia_de_conducir , $documento_de_la_cedula_profesional, $documento_de_la_carta_de_pasante, $documento_del_curriculum_vitae, $documento_del_contrato, $documento_del_requisicion_firmada, $documento_del_curp, $documento_de_caratula_bancaria, $documento_de_cedula_fiscal, $documento_del_acta_de_nacimiento, $documento_del_seguro_social, $otros_documentos;

    //HORARIO
    public $days = [];
    public $hora_de_entrada, $hora_de_salida;

    public $horario;

    public $number_jornaulis;
    public $hora_entrada, $hora_salida, $day_entrada, $day_salida;
    //HORARIO PREDETERMINADO
    public $horario_predeterminado;

    public function mount(User $user){
        $this->user = $user;
        $this->document = $user->document;

        $this->qr = $user->qr;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->curp = $user->curp;
        
        if(isset($user->fecha_de_nacimiento)){
            $this->fecha_de_nacimiento = $user->fecha_de_nacimiento->format('Y-m-d');
        }

        $this->código_del_país = substr($user->whatsapp, 0, -10);
        $this->número_de_teléfono = substr($user->whatsapp, -10);

        if(isset($user->fecha_de_ingreso)){
            $this->fecha_de_ingreso = $user->fecha_de_ingreso->format('Y-m-d');
        }

        $this->tipo_de_puesto = $this->user->tipo_de_puesto;

        if(isset($user->company_id)){
            $this->cost_centers = CostCenter::where('company_id', $user->company_id)->orderBy('folio')->get();
        }

        if(isset($user->userSetting)){
            $this->derecho_a_hora_extra = $user->userSetting->derecho_a_hora_extra;
            $this->recontratable = $user->userSetting->recontratable;
        }

        $this->estatus = $user->estatus;
        $this->rh = $user->rh;

        $this->cost_center = $this->user->cost_center_id;

        if($user->areas->count()){
            $pivot = $user->areas->first()->pivot;

            if($pivot != null){
                $this->área = $pivot->area_id;
                $this->encargado = $pivot->encargado_id;
            }
        }

        $this->company = $user->company_id;
        $this->tipo = $user->tipo;

        if($user->roles->count()){
            $this->role = $user->roles->pluck('id')[0];
        }

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
                        $this->day_entrada[$i] = isset($jornada['dia_entrada']) ? $jornada['dia_entrada'] : null;
                        $this->hora_entrada[$i] = isset($jornada['hora_entrada']) ? $jornada['hora_entrada'] : null;
                        $this->day_salida[$i] = isset($jornada['dia_salida']) ? $jornada['dia_salida'] : null;
                        $this->hora_salida[$i] = isset($jornada['hora_salida']) ? $jornada['hora_salida'] : null;
                    }
                }
            }
        }      
    }

    public function updatedcompany($company){
        $this->cost_centers = CostCenter::where('company_id', $company)->orderBy('folio')->get();
        $this->cost_center = '';
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
        $array['curp'] = ['required', 'string', 'min:18', 'max:18', 'unique:users,curp,'.$this->user->id];
        $array['fecha_de_nacimiento'] = 'nullable|date';

        if($this->código_del_país || $this->número_de_teléfono){
            $array['código_del_país'] = 'required|digits_between:1,3';
            $array['número_de_teléfono'] = 'required|digits:10';
        }

        $array['email'] = ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$this->user->id];
        $array['user.número_de_inscripción_al_imss'] = 'nullable|string|max:255';
        $array['user.rfc'] = ['required',/* 'regex:/^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/',*/'string','max:255'];
        $array['user.número_del_infonavit'] = 'nullable|string|max:255';

        //Work
        $array['user.número_de_empleado'] = 'required|numeric|max:99999999|unique:users,número_de_empleado,'.$this->user->id;
        $array['user.puesto'] = 'nullable|string|max:255';
        //$array['tipo_de_puesto'] = 'nullable|string|max:255';
        $array['company'] = ['required'];
        $array['cost_center'] = ['nullable'];
        $array['tipo'] = ['required'];

        //User Settings
        $array['derecho_a_hora_extra'] = "required|in:Si,No";
        $array['recontratable'] = "required|in:Si,No";

        $array['estatus'] = "required|in:Activo,Inactivo,Baja definitiva";
        $array['tipo_de_puesto'] = "required|in:Dirección,Gerencia,Jefatura,Administrativo,Rh,Administrativo_obras,Operacion";

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
        $array['documento_del_contrato'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_de_cedula_fiscal'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_del_curp'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_del_requisicion_firmada'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_del_acta_de_nacimiento'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_del_seguro_social'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['otros_documentos'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];

        $array['role'] = ['required'];

        return $array;
    }

    protected $messages = [
        'tipo.required' => 'El campo estatus es requerido.',
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

        if($this->derecho_a_hora_extra){
            if(isset($this->user->userSetting)){
                $this->user->userSetting->derecho_a_hora_extra = $this->derecho_a_hora_extra;
                $this->user->userSetting->recontratable = $this->recontratable;
                $this->user->userSetting->save();
            }else{
                UserSetting::create([
                    'derecho_a_hora_extra' => $this->derecho_a_hora_extra,
                    'recontratable' => $this->recontratable,
                    'user_id' => $this->user->id
                ]);
            }
        }else{
            if(!isset($this->user->userSetting)){
                UserSetting::create([
                    'derecho_a_hora_extra' => 'No',
                    'recontratable' => 'Si',
                    'user_id' => $this->user->id
                ]);
            }
        }

        //Docs
        if($this->documento_de_identificación_oficial){
            Storage::delete([$this->document->documento_de_identificación_oficial]);
            //$this->document->documento_de_identificación_oficial = $this->documento_de_identificación_oficial->store('identificaciones_oficiales');
            $this->document->documento_de_identificación_oficial = $this->documento_de_identificación_oficial->storeAs("identificaciones_oficiales", $this->documento_de_identificación_oficial->store(null), "private");
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

        if($this->documento_del_contrato){
            Storage::delete([$this->document->documento_del_contrato]);
            $this->document->documento_del_contrato = $this->documento_del_contrato->store('contratos');
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
            $this->document->documento_del_acta_de_nacimiento = $this->documento_del_acta_de_nacimiento->store('acta_de_nacimiento');
        }

        if($this->documento_del_seguro_social){
            Storage::delete([$this->document->documento_del_seguro_social]);
            $this->document->documento_del_seguro_social = $this->documento_del_seguro_social->store('seguro_social');
        }

        if($this->otros_documentos){
            Storage::delete([$this->document->otros_documentos]);
            $this->document->otros_documentos = $this->otros_documentos->store('otros_documentos');
        }

        if(isset($this->user->document)){
            $this->user->document->save();
        }

        if($this->código_del_país != null || $this->número_de_teléfono != null && $this->código_del_país != '' && $this->número_de_teléfono != ''){
            $whatsapp = $this->código_del_país.$this->número_de_teléfono;
        }else{
            $whatsapp = null;
        }

        if($this->cost_center == ""){
            $this->cost_center = null;
        }

        $this->user->qr = $this->qr;
        $this->user->email = $this->email;
        $this->user->curp = $this->curp;
        $this->user->fecha_de_nacimiento = $this->fecha_de_nacimiento;
        $this->user->whatsapp = $whatsapp;
        $this->user->password = Hash::make(mb_strtoupper($this->curp, 'UTF-8'));
        $this->user->fecha_de_ingreso = $this->fecha_de_ingreso;
        $this->user->tipo_de_puesto = $this->tipo_de_puesto;
        $this->user->company_id = $this->company;
        $this->user->cost_center_id = $this->cost_center;
        $this->user->tipo = $this->tipo;

        $this->user->estatus = $this->estatus;

        //$user->roles()->detach();
        $this->user->areas()->syncWithPivotValues($this->área, ['encargado_id' => $this->encargado]);
        $this->user->roles()->sync($this->role);
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

        session()->flash('message', 'Empleado se editó satisfactoriamente.');

        return redirect(route('admin.users.index'));
    }

    public function render()
    {
            $companies = Company::orderBy('nombre_de_la_compañia')->get();
            $cost_centers = CostCenter::orderBy('folio')->get();
            $areas = Area::orderBy('área')->get();
            $users = User::orderBy('name')->get();
            $roles = Role::orderBy('name')->get();
           

            $default_schedules = DefaultSchedule::orderBy('nombre_del_horario')->get();

        return view('livewire.admin.users.users-edit', [
            'companies' => $companies,
            'cost_centers' => $cost_centers,
            'areas' => $areas,
            'roles' => $roles,
            'users' => $users,
            'default_schedules' => $default_schedules,
            
        ]);
    }
}
