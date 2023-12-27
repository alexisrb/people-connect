<?php

namespace App\Http\Livewire\Admin\Assistances;

use App\Models\Area;
use App\Models\Assistance;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class AssistancesIndex extends Component
{
    use WithPagination;

    public $search, $order, $date, $from, $to, $from_ina, $to_ina;
    public $sort = 'id';
    public $direction = 'desc';
    protected $paginationTheme = "bootstrap";

    public $searchName, $área, $compañia, $estatus;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function updatedorder($order){
        if($order == 1){
            $this->direction = 'asc';
        }
        switch($order){
            case 1:
                $this->sort = 'id';
                $this->direction = 'desc';
            break;
            case 2:
                $this->sort = 'id';
                $this->direction = 'asc';
            break;
        }
    }

    public function __construct()
    {
        $hoy = Carbon::now();
        $this->date = $hoy->format('Y-m-d');
        $this->from = $hoy->format('Y-m-d');
        $this->to = $hoy->format('Y-m-d');
        $this->from_ina = $hoy->format('Y-m-d');
        $this->to_ina = $hoy->format('Y-m-d');
    }

    public function render()
    {
        
        $assistances = Assistance::whereDate('created_at', '>=' , Carbon::now()->formatLocalized($this->from))->whereDate('created_at', '<=' , Carbon::now()->formatLocalized($this->to))
        ->where('user_id', '!=', null)
        ->when($this->searchName, function($query){
            $query->whereHas('user', function($query){
                $query->where('name', 'LIKE', '%' . $this->searchName . '%');
            });
        })
        ->when($this->área, function($query){
            $query->whereHas('user', function($query){
                $query->whereHas('areas', function($query){
                        $query->where('area_id', $this->área);
                });
            });
        })
        ->when($this->compañia, function($query){
            $query->whereHas('user', function($query){
                $query->where('company_id', $this->compañia);
            });
        })
        ->when($this->estatus, function($query){
            $query->where('asistencia', $this->estatus);
        })
        ->orderBy($this->sort, $this->direction)
        ->latest('id')
        ->paginate();

        $all_assistances = Assistance::whereDate('created_at', '>=' , Carbon::now()->formatLocalized($this->to))->whereDate('created_at', '<=' , Carbon::now()->formatLocalized($this->from))->where('asistencia', 'No asistió')->count();

        // $usuariosSinFoto = Assistance::whereDate('created_at', '=', Carbon::now()->formatLocalized($this->date))->whereHas('user', function($query){
        //     $query->where('tipo', 'Empleado')->doesntHave('image');
        // })->count();

        // $usuariosConFoto = Assistance::whereDate('created_at', '=', Carbon::now()->formatLocalized($this->date))->whereHas('user', function($query){
        //     $query->where('tipo', 'Empleado')->wherehas('image');
        // })->count();

        $areas = Area::orderBy('área')->get();

        $companies = Company::orderBy('nombre_de_la_compañia')->get();


        return view('livewire.admin.assistances.assistances-index', [
            'assistances' => $assistances,
            'all_assistances' => $all_assistances,
            // 'usuariosSinFoto' => $usuariosSinFoto,
            // 'usuariosConFoto' => $usuariosConFoto,
            'areas' => $areas,
            'companies' => $companies,
        ]);
    }
}
