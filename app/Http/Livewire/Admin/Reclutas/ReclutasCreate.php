<?php

namespace App\Http\Livewire\Admin\Reclutas;

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
use Spatie\Permission\Models\Role;

use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class ReclutasCreate extends Component
{
    use WithFileUploads;

    //User
    public $foto, $qr, $name, $email, $curp, $company, $área, $puesto, $tipo_de_puesto, $tipo,
        $número_de_inscripción_al_imss, $rfc, $número_del_infonavit;

    //Schedule
    public $horario;

    public $number_jornaulis;
    public $hora_entrada, $hora_salida, $day_entrada, $day_salida;

        //HORARIO PREDETERMINADO
        public $horario_predeterminado;

    //Docs
    public $documento_de_identificación_oficial, $documento_del_comprobante_de_domicilio, $documento_de_no_antecedentes_penales,
        $documento_de_la_licencia_de_conducir , $documento_de_la_cedula_profesional, $documento_de_la_carta_de_pasante, $documento_del_curriculum_vitae, $documento_del_requisicion_firmada, $documento_del_curp, $documento_de_caratula_bancaria, $documento_de_cedula_fiscal, $documento_del_acta_de_nacimiento, $documento_del_seguro_social, $otros_documentos;

    public function rules(){
        
        $array = [];

        //User
        $array['foto'] = 'nullable|image|mimes:jpeg,jpg,png|max:5048';
        $array['name'] = 'required|string|max:255';
        $array['email'] = ['required', 'string', 'email', 'max:255', Rule::unique(User::class)];
        $array['curp'] = ['required', 'string', 'min:18', 'max:18', /*'regex:/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/',*/ 'unique:users,curp'];
        $array['número_de_inscripción_al_imss'] = 'nullable|string|max:255';
        $array['rfc'] = ['required', /*'regex:/^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/',*/ 'string','max:255'];
        $array['número_del_infonavit'] = 'nullable|string|max:255';

        //Work
        $array['puesto'] = 'nullable|string|max:255';
        $array['tipo_de_puesto'] = 'nullable|string|max:255';
        $array['tipo'] = ['required'];
        $array['company'] = ['required'];
        $array['horario_predeterminado'] = ['required'];
        $array['área'] = ['nullable'];

        //Schedule
        //if(count($this->days)){
        //    foreach($this->days as $n => $day){
        //        $array['hora_de_entrada.'.$n] = 'required';
        //        $array['hora_de_salida.'.$n] = 'required';
        //    }
        //}

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

    public function updatedemail($email){
        $this->qr = 'email='.$this->email.'&curp='.$this->curp;
    }

    public function updatedcurp($curp){
        $this->qr = 'email='.$this->email.'&curp='.$this->curp;
    }

    protected $messages = [
        'tipo.required' => 'El campo estatus es requerido.',
        'horario_predeterminado.required' => 'El campo Horario Predeterminado es obligatorio.',
    ];

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
            'documento_de_caratula_bancaria' => $documento_de_caratula_bancaria,
            'documento_de_cedula_fiscal' => $documento_de_cedula_fiscal,
            'documento_del_curp' => $documento_del_curp,
            'documento_del_requisicion_firmada' => $documento_del_requisicion_firmada,
            'documento_del_acta_de_nacimiento' => $documento_del_acta_de_nacimiento,
            'documento_del_seguro_social' => $documento_del_seguro_social,
            'otros_documentos' => $otros_documentos
            
        ]);
        

        //USER  
        $user = User::create([
            'qr' => $this->qr,
            'name' => $this->name,
            'email' => $this->email,
            'curp' => $this->curp,
            'número_de_empleado' => null,
            'company_id' => $this->company,
            'puesto' => $this->puesto,
            'tipo_de_puesto' => $this->tipo_de_puesto,
            'tipo' => $this->tipo,
            'password' => Hash::make($this->curp),
            //'password' => Hash::make($this->password),
            'estatus' => 'Activo',
            'número_de_inscripción_al_imss' => $this->número_de_inscripción_al_imss,
            'rfc' => $this->rfc,
            'número_del_infonavit' => $this->número_del_infonavit,
            'document_id' => $document->id,
            'slug' => Str::random(30)
        ]);

        //ÁREA Y ENCARGADO
        if($this->área){
            $user->areas()->sync($this->área);
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
        //SCHEDULE
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


        $user->roles()->sync(3);

        session()->flash('message', 'Reclutado creado satisfactoriamente.');

        return redirect(route('admin.reclutas.index'));
    }

    public function render()
    {
        $companies = Company::orderBy('nombre_de_la_compañia')->get();
        $areas = Area::orderBy('área')->get();
        $users = User::orderBy('name')->get();

        $default_schedules = DefaultSchedule::orderBy('nombre_del_horario')->get();
        return view('livewire.admin.reclutas.reclutas-create',[
            'companies' => $companies,
            'areas' => $areas,
            'users' => $users,
            'default_schedules' => $default_schedules
        ]);
    }
}
