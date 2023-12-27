<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersActivesExport;
use App\Exports\UsersAreaExport;
use App\Exports\UsersCompletedExport;
use App\Exports\UsersCostCenterExport;
use App\Exports\UsersEnterpriseExport;
use App\Exports\UsersWithoutImageExport;
use App\Exports\UsersWithoutPuestoExport;
use App\Exports\UsersWithoutSchedule;
use App\Http\Controllers\Controller;
use App\Models\CheckAssistance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('can:admin.users.index')->only('index');
        $this->middleware('can:admin.users.edit')->only('edit');
        $this->middleware('can:admin.users.show')->only('show');
        $this->middleware('can:admin.users.create')->only('create');
        $this->middleware('can:admin.users.destroy')->only('destroy');
       
    }

    public function index()
    {
        return view('admin.users.index');
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function destroy(User $user)
    {
        //Ver tipo para redireccionar
        if($user->tipo){
            $tipo = $user->tipo;
        }

        //Foto
        if($user->image){
            Storage::delete($user->image->url);

            $user->image->delete();
        }

        //Documentos
        if($user->document){

            if($user->document->documento_de_identificación_oficial){
                Storage::delete($user->document->documento_de_identificación_oficial);
            }

            if($user->document->documento_del_comprobante_de_domicilio){
                Storage::delete($user->document->documento_del_comprobante_de_domicilio);
            }

            if($user->document->documento_de_no_antecedentes_penales){
                Storage::delete($user->document->documento_de_no_antecedentes_penales);
            }

            if($user->document->documento_de_la_licencia_de_conducir){
                Storage::delete($user->document->documento_de_la_licencia_de_conducir);
            }

            if($user->document->documento_de_la_cedula_profesional){
                Storage::delete($user->document->documento_de_la_cedula_profesional);
            }

            if($user->document->documento_de_la_carta_de_pasante){
                Storage::delete($user->document->documento_de_la_carta_de_pasante);
            }

            if($user->document->documento_del_curriculum_vitae){
                Storage::delete($user->document->documento_del_curriculum_vitae);
            }

            $user->document->delete();
        }

        $user->delete();

        //Redirección
        switch($tipo){
            case 'Empleado':
                return redirect()->route('admin.users.index')->with('eliminar', 'ok');
            break;
            case 'Recluta':
                return redirect()->route('admin.reclutas.index')->with('eliminar', 'ok');
            break;

            default:

        }
    }

    //CONTRATOS
    public function contratoTD(User $user){
        $edad = Carbon::parse($user->fecha_de_nacimiento)->age;

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView("pdfs/admin/contratos/contratoTD", [
            'user' => $user,
            'edad' => $edad
        ]);

        $pdf->set_option('isRemoteEnabled', true);

        return $pdf->stream("contratoTD.pdf");
    }

    //CONTRATOS
    public function contratoTI(User $user){
        $edad = Carbon::parse($user->fecha_de_nacimiento)->age;

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView("pdfs/admin/contratos/contratoTI", [
            'user' => $user,
            'edad' => $edad
        ]);

        $pdf->set_option('isRemoteEnabled', true);

        return $pdf->stream("contratoTI.pdf");
    }

    public function usersWithoutImageExportExcel(){
        return Excel::download(new UsersWithoutImageExport, 'usuarios_sin_image.xlsx');
    }

    public function usersWithoutPuestoExportExcel(){
        return Excel::download(new UsersWithoutPuestoExport, 'usuarios_sin_puesto.xlsx');
    }

    public function usersCompletedExportExcel(){
        return Excel::download(new UsersCompletedExport, 'usuarios_completos.xlsx');
    }

    public function usersActivesExportExcel(){
        return Excel::download(new UsersActivesExport, 'usuarios_activos.xlsx');
    }

    public function usersWithCostCenterExportExcel(){
        return Excel::download(new UsersCostCenterExport, 'usuarios_con_centro_costos.xlsx');
    }

    public function usersWithEnterpriseExportExcel(){
        return Excel::download(new UsersEnterpriseExport, 'usuarios_con_empresa.xlsx');
    }

    public function usersWithAreaExportExcel(){
        return Excel::download(new UsersAreaExport, 'usuarios_con_area.xlsx');
    }

    public function usersWithoutSchedule(){
        return Excel::download(new UsersWithoutSchedule, 'usuarios_sin_horario.xlsx');
    }

    public function updateStatus($id)
	{
		User::where('id', $id)
      		->update(['estatus' => 'Baja Definitiva']);
    
        return view('admin.users.index');
	}


    public function check_assistance(User $user){
        $dia = Carbon::now();
        CheckAssistance::create([
            'fecha' => $dia,
            'hora' => $dia->format('H:i:s'),
            'estatus' => 'Asistio',
            'user_id' => $user->id,
            'user_check_id' => auth()->user()->id
        ]);
        return view('admin.users.index');
    }

    public function check_no_assistance(User $user){
        $dia = Carbon::now();
        CheckAssistance::create([
            'fecha' => $dia,
            'hora' => $dia->format('H:i:s'),
            'estatus' => 'No Asistio',
            'user_id' => $user->id,
            'user_check_id' => auth()->user()->id
        ]);
        return view('admin.users.index');
    }
}
