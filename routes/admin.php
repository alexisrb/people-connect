<?php

//Home

use App\Http\Controllers\Admin\AdministrativeRecordController;
use App\Http\Controllers\Admin\AdmonitionController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\CheckController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AssistanceController;
use App\Http\Controllers\Admin\CostCenterController;
use App\Http\Controllers\Admin\ReclutaController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\VacationController;
use App\Http\Controllers\Admin\AdmonitionTypeController;
use App\Http\Controllers\Admin\CheckAssistanceController;
use App\Http\Controllers\Admin\ComputerController;
use App\Http\Controllers\Admin\DefaultScheduleController;
use App\Http\Controllers\Admin\DeviceController;
use App\Http\Controllers\Admin\ElectronicController;
use App\Http\Controllers\Admin\ExtraHourController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\NonWorkingDayController;
use App\Http\Controllers\Admin\PhoneController;
use App\Http\Controllers\Admin\PrinterController;
use App\Http\Controllers\Admin\SafetyController;
use App\Http\Controllers\ExtraordinaryController;
use App\Http\Controllers\JustificationController;
use Illuminate\Support\Facades\Route;

Route::get('', [HomeController::class, 'index'])->name('admin.index');

//Areas
Route::resource('areas', AreaController::class)->only(['index', 'create', 'edit', 'show', 'destroy'])->names('admin.areas');

//Users
Route::resource('users', UserController::class)->only(['index', 'create', 'edit', 'show', 'destroy'])->names('admin.users');
Route::get('/actualizar_usuario/{id}', [UserController::class, 'updateStatus'])->middleware('auth')->name('admin.users.estatus');
Route::get('/check_assistance/{user}', [UserController::class, 'check_assistance'])->middleware('auth')->name('admin.users.check');
Route::get('/check_no_assistance/{user}', [UserController::class, 'check_no_assistance'])->middleware('auth')->name('admin.users.no_check');
    //PDFS
    Route::get('/contratos-de-tiempo-determinado/pdfs/{user}', [UserController::class, 'contratoTD'])->middleware('auth')->name('pdfs.contratoTD.view');
    Route::get('/contratos-de-tiempo-indeterminado/pdfs/{user}', [UserController::class, 'contratoTI'])->middleware('auth')->name('pdfs.contratoTI.view');

//Reclutas
Route::resource('recluta', ReclutaController::class, ['parameters'=> ['{user}' => 'user']])->only(['index', 'create', 'edit', 'show', 'destroy'])->names('admin.reclutas');

//Checks
Route::resource('checks', CheckController::class)->only(['index', 'show'])->names('admin.checks');

//Schedules
Route::resource('schedules', ScheduleController::class)->only(['destroy', 'edit'])->names('admin.schedules');

//Assistances
Route::resource('assistances', AssistanceController::class)->only(['index', 'show'])->names('admin.assistances');

//Justificaciones
Route::resource('justifications', JustificationController::class)->only(['index', 'show'])->names('admin.justifications');

//Horas extra extraordinarias 
Route::resource('extraordinary-overtime', ExtraordinaryController::class)->only(['index', 'show', 'create'])->names('admin.extraordinary');

//Pase de lista. 
Route::resource('check_asistances', CheckAssistanceController::class)->only(['index', 'show', 'create'])->names('admin.check_assitance');

//Vacaciones
Route::resource('vacations', VacationController::class)->only(['index', 'create', 'show'])->names('admin.vacations');

//Inventories
Route::resource('inventories', InventoryController::class)->only(['index', 'create', 'edit', 'show', 'destroy'])->names('admin.inventories');

//Electronic
Route::resource('electronics', ElectronicController::class)->only(['index', 'create', 'edit', 'show', 'destroy'])->names('admin.electronics');

//Printers
Route::resource('printers', PrinterController::class)->only(['index', 'create', 'edit', 'show', 'destroy'])->names('admin.printers');

//Phones
Route::resource('phones', PhoneController::class)->only(['index', 'create', 'edit', 'show', 'destroy'])->names('admin.phones');

//Computers
Route::resource('computers', ComputerController::class)->only(['index', 'create', 'edit', 'show', 'destroy'])->names('admin.computers');

//Horas extras
Route::resource('extra-hours', ExtraHourController::class)->only(['index', 'create', 'edit', 'show', 'destroy'])->names('admin.extra_hours');

//Admonition types
Route::resource('default-schedules', DefaultScheduleController::class)->only(['index', 'create', 'edit', 'show', 'destroy'])->names('admin.default_schedules');

//Admonitions
Route::resource('admonitions', AdmonitionController::class)->only(['index', 'show', 'create'])->names('admin.admonitions');
    //PDFS
    Route::get('/admonitions/pdfs/{admonition}', [AdmonitionController::class, 'pdf'])->middleware('auth', 'can:admin.admonitions.pdfs')->name('pdfs.admonitions.view');

//Admonition types
Route::resource('admonition-types', AdmonitionTypeController::class)->only(['index', 'create', 'edit', 'show', 'destroy'])->names('admin.admonition_types');

//Calendar
Route::get('/calendars', [NonWorkingDayController::class, 'index'])->name('admin.calendars.index');
Route::get('/calendars/create', [NonWorkingDayController::class, 'create'])->name('admin.calendars.create');
Route::get('/calendars/edit/{non_working_day}', [NonWorkingDayController::class, 'edit'])->name('admin.calendars.edit');
Route::delete('/calendars/{non_working_day}', [NonWorkingDayController::class, 'destroy'])->name('admin.calendars.destroy');

//Administrative records
Route::resource('administrative-records', AdministrativeRecordController::class)->only(['index', 'create', 'edit', 'show', 'destroy'])->names('admin.administrative_records');

    //PDFS
    Route::get('/administrative-records/pdfs/{administrative_record}', [AdministrativeRecordController::class, 'pdf'])->middleware('auth', 'can:admin.administrative_records.pdfs')->name('pdfs.administrative_records.view');

//Cost centers
Route::resource('cost-centers', CostCenterController::class)->only(['index', 'create', 'edit', 'show', 'destroy'])->names('admin.cost_centers');

//Computers
Route::resource('devices', DeviceController::class)->only(['index', 'create', 'edit', 'show', 'destroy'])->names('admin.devices');

//Safeties
Route::resource('safeties', SafetyController::class)->only(['index', 'create', 'edit', 'show', 'destroy'])->names('admin.safeties');

//Roles
Route::resource('roles', RoleController::class)->only(['index', 'create', 'edit', 'show', 'destroy'])->names('admin.roles');

//Aprove ExtraHours
Route::get('/extraordinary-overtime/aprove/{id}', [ExtraordinaryController::class, 'aprove'])->name('admin.extraordinary.aprove');
//Disaprove ExtraHours
Route::get('/extraordinary-overtime/disaprove/{id}', [ExtraordinaryController::class, 'disaprove'])->name('admin.extraordinary.disaprove');

//EXCEL
Route::get('/excel-de-usuarios-sin-imagen', [UserController::class, 'usersWithoutImageExportExcel'])->name('admin.usersWithoutImage.export');
Route::get('/excel-de-usuarios-sin-puesto', [UserController::class, 'usersWithoutPuestoExportExcel'])->name('admin.usersWithoutPuesto.export');
Route::get('/excel-de-usuarios-completos', [UserController::class, 'usersCompletedExportExcel'])->name('admin.usersCompleted.export');
Route::get('/excel-de-usuarios-activos', [UserController::class, 'usersActivesExportExcel'])->name('admin.usersActives.export');
Route::get('/excel-de-usuarios-con-empresa', [UserController::class, 'usersWithEnterpriseExportExcel'])->name('admin.usersWithEnterprise.export');
Route::get('/excel-de-usuarios-con-area', [UserController::class, 'usersWithAreaExportExcel'])->name('admin.usersWithArea.export');
Route::get('/excel-de-usuarios-con-centro-costos', [UserController::class, 'usersWithCostCenterExportExcel'])->name('admin.usersWithCostCenter.export');
Route::get('/excel-assistances/{from}/{to}', [AssistanceController::class, 'excel'])->name('admin.assistances.export');
Route::get('/excel-de-asistencias', [CheckController::class, 'checksToday'])->name('admin.checksToday.export');
Route::get('/excel-inasistencias/{from}/{to}', [AssistanceController::class, 'inassistance'])->name('admin.inassistances.export');//inassistance
Route::get('/excel-de-horas-extras', [ExtraHourController::class, 'extraHoursToday'])->name('admin.extraHours.export');
Route::get('/excel-de-justificaciones', [AssistanceController::class, 'justifyExcel'])->name('admin.justify.export');
Route::get('/excel-de-horarios', [UserController::class, 'usersWithoutSchedule'])->name('admin.user.schedule');
Route::get('/excel-justificaciones/{from}/{to}', [AssistanceController::class, 'justifyRange'])->name('admin.justificaciones.export');

//CALCULAR ASISTENCIAS E INASISTENCIAS
Route::get('/calcular-asistencias-de-hoy-favor-de-respaldar-antes-y-solo-ejecutar-una-vez', [AssistanceController::class, 'calcularAsistenciasDeHoy']);
Route::get('/calcular-inasistencias-de-hoy-favor-de-respaldar-antes-y-solo-ejecutar-una-vez', [AssistanceController::class, 'calcularInasistenciasDeHoy']);
