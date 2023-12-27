<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\Area;
use App\Models\Company;
use App\Models\CostCenter;
use App\Models\DefaultSchedule;
use App\Models\Image;
use App\Models\Schedule;
use App\Models\User;
use App\Models\UserDocuments;
use App\Models\UserSetting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class UsersCreate extends Component
{
    use WithFileUploads;

    //Auxiliar
    public $registrarPor = 'curp';

    //User
    public $foto, $qr, $name, $email, $curp, $código_del_país, $número_de_teléfono, $fecha_de_nacimiento, $número_de_empleado, $company, $cost_centers, $cost_center, $área, $encargado, $fecha_de_ingreso, $puesto, $derecho_a_hora_extra = 'No', $recontratable = 'Si', $estatus = 'Activo', $tipo_de_puesto, $password, $password_confirmation, $role = 3,
        $número_de_inscripción_al_imss, $rfc, $número_del_infonavit, $rh='Dirección';

    //Schedule
    public $horario;

    public $number_jornaulis;
    public $hora_entrada, $hora_salida, $day_entrada, $day_salida;

        //HORARIO PREDETERMINADO
        public $horario_predeterminado;

    //Docs
    public $documento_de_identificación_oficial, $documento_del_comprobante_de_domicilio, $documento_de_no_antecedentes_penales,
        $documento_de_la_licencia_de_conducir , $documento_de_la_cedula_profesional, $documento_de_la_carta_de_pasante, $documento_del_curriculum_vitae, $documento_del_contrato, $documento_del_requisicion_firmada, $documento_del_curp, $documento_de_caratula_bancaria, $documento_de_cedula_fiscal, $documento_del_acta_de_nacimiento, $documento_del_seguro_social, $otros_documentos;

    public function rules(){

        $array = [];

        //User
        $array['foto'] = 'nullable|image|mimes:jpeg,jpg,png|max:5048';
        $array['name'] = 'required|string|max:255';
        $array['email'] = ['required', 'string', 'email', 'max:255', Rule::unique(User::class)];

        if($this->código_del_país || $this->número_de_teléfono){
            $array['código_del_país'] = 'required|digits_between:1,3';
            $array['número_de_teléfono'] = 'required|digits:10';
        }

        $array['curp'] = ['required', 'string', 'min:18', 'max:18', /*'regex:/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/',*/ 'unique:users,curp'];
        $array['fecha_de_nacimiento'] = 'nullable|date|date_format:Y-m-d';
        $array['número_de_inscripción_al_imss'] = 'nullable|string|max:255';
        $array['rfc'] = ['required', /*'regex:/^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/',*/ 'string','max:255'];
        $array['número_del_infonavit'] = 'nullable|string|max:255';

        //Work
        $array['número_de_empleado'] = 'required|numeric|max:99999999|unique:users,número_de_empleado';
        $array['fecha_de_ingreso'] = 'nullable|date|date_format:Y-m-d';
        $array['puesto'] = 'nullable|string|max:255';
        //$array['tipo_de_puesto'] = 'nullable|string|max:255';
        $array['company'] = ['required'];
        $array['cost_center'] = ['nullable'];

        if($this->área || $this->encargado){
            $array['área'] = ['required'];
            $array['encargado'] = ['required'];
        }

        //User Settings
        $array['derecho_a_hora_extra'] = "required|in:Si,No";
        $array['recontratable'] = "required|in:Si,No";

        $array['estatus'] = "required|in:Activo,Inactivo,Baja definitiva";
        $array['tipo_de_puesto'] = "required|in:Dirección,Gerencia,Jefatura,Administrativo,RH,Administrativo_obras,Operacion";

        //Schedule
        if ($this->number_jornaulis > 0) {
            for ($i = 0; $i < $this->number_jornaulis; $i++) {
                $prefix = "jornada" . ($i + 1);
        
                // Validar día de entrada
                if (empty($this->day_entrada[$prefix])) {
                    $array["day_entrada.{$prefix}"] = 'required';
                }
        
                // Validar día de salida
                if (empty($this->day_salida[$prefix])) {
                    $array["day_salida.{$prefix}"] = 'required';
                }
        
                // Validar hora de entrada
                if (empty($this->hora_entrada[$prefix])) {
                    $array["hora_entrada.{$prefix}"] = 'required';
                }
        
                // Validar hora de salida
                if (empty($this->hora_salida[$prefix])) {
                    $array["hora_salida.{$prefix}"] = 'required';
                }
            }
        } else {
            // Si no hay jornadas, validar el número
            $array['number_jornaulis'] = 'required';
        }

        //Docs
        $array['documento_de_identificación_oficial'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_del_comprobante_de_domicilio'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_de_no_antecedentes_penales'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_de_la_licencia_de_conducir'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_de_la_cedula_profesional'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_de_la_carta_de_pasante'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_del_curriculum_vitae'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_del_contrato'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_de_caratula_bancaria'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_de_cedula_fiscal'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_del_curp'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_del_requisicion_firmada'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_del_acta_de_nacimiento'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['documento_del_seguro_social'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];
        $array['otros_documentos'] = ['nullable','mimes:jpg,jpeg,png,svg,pdf','max:6000'];

        //Role
        $array['role'] = ['required'];

        if($this->registrarPor == 'password'){
            $array['password'] = 'required|confirmed';
        }

        return $array;
    }

    protected $messages = [
        'company.required' => 'El campo empresa / compañia es obligatorio.',
        'number_jornaulis.required' => 'El campo número de jornadas  es obligatorio.',
        'day_entrada.*.required' => 'El campo día de entrada para la jornada es obligatorio.',
        'day_salida.*.required' => 'El campo día de salida para la jornada es obligatorio.',
        'hora_entrada.*.required' => 'El campo hora de entrada para la jornada es obligatorio.',
        'hora_salida.*.required' => 'El campo hora de salida para la jornada es obligatorio.'
    ];

    //$_SERVER['SERVER_NAME'] test.test

    public function updatedemail($email){
        $this->qr = 'email='.$this->email.'&curp='.$this->curp;
    }

    public function updatedcurp($curp){
        $this->qr = 'email='.$this->email.'&curp='.$this->curp;
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

    public function save(){
        $this->validate();

        //DOCS
        if($this->documento_de_identificación_oficial){
            $documento_de_identificación_oficial = $this->documento_de_identificación_oficial->store('identificaciones_oficiales');
        }else{
            $documento_de_identificación_oficial = null;
        }

        if($this->documento_del_comprobante_de_domicilio){
            $documento_del_comprobante_de_domicilio = $this->documento_del_comprobante_de_domicilio->store('comprobantes_de_domicilio');
        }else{
            $documento_del_comprobante_de_domicilio = null;
        }

        if(
        $this->documento_de_no_antecedentes_penales){
            $documento_de_no_antecedentes_penales = $this->documento_de_no_antecedentes_penales->store('documentos_de_no_antecedentes_penales');
        }else{
            $documento_de_no_antecedentes_penales = null;
        }

        if($this->documento_de_la_licencia_de_conducir){
            $documento_de_la_licencia_de_conducir = $this->documento_de_la_licencia_de_conducir->store('licencias_de_conducir');
        }else{
            $documento_de_la_licencia_de_conducir = null;
        }

        if($this->documento_de_la_cedula_profesional){
            $documento_de_la_cedula_profesional = $this->documento_de_la_cedula_profesional->store('cedulas_profesionales');
        }else{
            $documento_de_la_cedula_profesional = null;
        }

        if($this->documento_de_la_carta_de_pasante){
            $documento_de_la_carta_de_pasante = $this->documento_de_la_carta_de_pasante->store('cartas_de_pasantes');
        }else{
            $documento_de_la_carta_de_pasante = null;
        }

        if($this->documento_del_curriculum_vitae){
            $documento_del_curriculum_vitae = $this->documento_del_curriculum_vitae->store('curriculums_vitaes');
        }else{
            $documento_del_curriculum_vitae = null;
        }

        if($this->documento_del_contrato){
            $documento_del_contrato = $this->documento_del_contrato->store('contratos');
        }else{
            $documento_del_contrato = null;
        }

        if($this->documento_de_caratula_bancaria){
            $documento_de_caratula_bancaria = $this->documento_de_caratula_bancaria->store('caratula_bancaria');
        }else{
            $documento_de_caratula_bancaria = null;
        }

        if($this->documento_de_cedula_fiscal){
            $documento_de_cedula_fiscal = $this->documento_de_cedula_fiscal->store('cedula_fiscal');
        }else{
            $documento_de_cedula_fiscal = null;
        }

        if($this->documento_del_curp){
            $documento_del_curp = $this->documento_del_curp->store('curp');
        }else{
            $documento_del_curp = null;
        }

        if($this->documento_del_requisicion_firmada){
            $documento_del_requisicion_firmada = $this->documento_del_requisicion_firmada->store('requisicion_firmada');
        }else{
            $documento_del_requisicion_firmada = null;
        }
        
        if($this->documento_del_acta_de_nacimiento){
            $documento_del_acta_de_nacimiento = $this->documento_del_acta_de_nacimiento->store('acta_de_nacimiento');
        }else{
            $documento_del_acta_de_nacimiento = null;
        }

        if($this->documento_del_seguro_social){
            $documento_del_seguro_social = $this->documento_del_seguro_social->store('seguro_social');
        }else{
            $documento_del_seguro_social = null;
        }

        if($this->otros_documentos){
            $otros_documentos = $this->otros_documentos->store('otros_documentos');
        }else{
            $otros_documentos = null;
        }

        $document = UserDocuments::create([
            'documento_de_identificación_oficial' => $documento_de_identificación_oficial,
            'documento_del_comprobante_de_domicilio' => $documento_del_comprobante_de_domicilio,
            'documento_de_no_antecedentes_penales' => $documento_de_no_antecedentes_penales,
            'documento_de_la_licencia_de_conducir' => $documento_de_la_licencia_de_conducir,
            'documento_de_la_cedula_profesional' => $documento_de_la_cedula_profesional,
            'documento_de_la_carta_de_pasante' => $documento_de_la_carta_de_pasante,
            'documento_del_curriculum_vitae' => $documento_del_curriculum_vitae,
            'documento_del_contrato' => $documento_del_contrato,
            'documento_de_caratula_bancaria' => $documento_de_caratula_bancaria,
            'documento_de_cedula_fiscal' => $documento_de_cedula_fiscal,
            'documento_del_curp' => $documento_del_curp,
            'documento_del_requisicion_firmada' => $documento_del_requisicion_firmada,
            'documento_del_acta_de_nacimiento' => $documento_del_acta_de_nacimiento,
            'documento_del_seguro_social' => $documento_del_seguro_social,
            'otros_documentos' => $otros_documentos
        ]);

        if(isset($this->código_del_país) || isset($this->número_de_teléfono) && $this->código_del_país != '' && $this->número_de_teléfono != ''){
            $whatsapp = $this->código_del_país.$this->número_de_teléfono;
        }else{
            $whatsapp = null;
        }

        if($this->cost_center == ''){
            $cost_center = null;
        }else{
            $cost_center = $this->cost_center;
        }

        if($this->registrarPor == 'password'){
            $clave = $this->password;
        }else{
            $clave = $this->curp;
        }

        //USER
        $user = User::create([
            'qr' => $this->qr,
            'name' => $this->name,
            'email' => $this->email,
            'curp' => $this->curp,
            'whatsapp' => $whatsapp,
            'fecha_de_nacimiento' => $this->fecha_de_nacimiento,
            'número_de_empleado' => $this->número_de_empleado,
            'fecha_de_ingreso' => $this->fecha_de_ingreso,
            'company_id' => $this->company,
            'cost_center_id' => $cost_center,
            'puesto' => $this->puesto,
            'tipo_de_puesto' => $this->tipo_de_puesto,
            'rh' => $this->rh,
            'tipo' => 'Empleado',
            'password' => Hash::make($clave),
            //'password' => Hash::make($this->password),
            'estatus' => $this->estatus,
            'número_de_inscripción_al_imss' => $this->número_de_inscripción_al_imss,
            'rfc' => $this->rfc,
            'número_del_infonavit' => $this->número_del_infonavit,
            'document_id' => $document->id,
            'slug' => Str::random(30)
        ]);

        if($this->derecho_a_hora_extra || $this->recontratable){
            UserSetting::create([
                'derecho_a_hora_extra' => $this->derecho_a_hora_extra,
                'recontratable' => $this->recontratable,
                'user_id' => $user->id
            ]);
        }
        //ÁREA Y ENCARGADO
        if($this->área || $this->encargado){
            $user->areas()->syncWithPivotValues($this->área, ['encargado_id' => $this->encargado]);
        }


        if($this->foto){
            //FOTO
            Image::create([
                'url' => $this->foto->storeAs("fotos", $this->foto->store('fotos'), "private"),
                'imageable_id' => $user->id,
                'imageable_type' => 'App\Models\User'
            ]);
        }

        //SCHEDULE
        if(!empty($this->number_jornaulis)){
            for($i = 0; $i<$this->number_jornaulis; $i++){
                $jornada = array(
                    'dia_entrada' => $this->day_entrada["jornada" . ($i + 1)],
                    'hora_entrada' => $this->hora_entrada["jornada" . ($i + 1)],
                    'dia_salida' => $this->day_salida["jornada" . ($i + 1)],
                    'hora_salida' => $this->hora_salida["jornada" . ($i + 1)],
                );
                $schedule["jornada" . ($i + 1)] =  $jornada;
            }
            Schedule::create([
                'tipo_jornada' => null,
                'tipo_horas' => null,
                'number_journaly' => $this->number_jornaulis,
                'schedule' => json_encode($schedule),
                'scheduleble_id' => $user->id,
                'scheduleble_type' => User::class,
                'actual' => true,
                'día' => null,
                'hora_de_entrada' => null,
                'hora_de_salida' => null,
                'turno' => null,
                'posición' => null
            ]);
        }

        $user->roles()->sync($this->role);

        session()->flash('message', 'Empleado creado satisfactoriamente.');
        return redirect(route('admin.users.index'));
    }

    public function render()
    {
        $companies = Company::orderBy('nombre_de_la_compañia')->get();
        //$cost_centers = CostCenter::orderBy('folio')->get();
        $roles = Role::orderBy('name')->get();
        $areas = Area::orderBy('área')->get();
        $users = User::orderBy('name')->get();

        $default_schedules = DefaultSchedule::orderBy('nombre_del_horario')->get();

        return view('livewire.admin.users.users-create',[
            'companies' => $companies,
            //'cost_centers' => $cost_centers,
            'roles' => $roles,
            'areas' => $areas,
            'users' => $users,
            'default_schedules' => $default_schedules
        ]);
    }
}
