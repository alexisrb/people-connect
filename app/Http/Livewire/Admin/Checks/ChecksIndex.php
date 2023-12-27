<?php

namespace App\Http\Livewire\Admin\Checks;

use App\Models\Area;
use App\Models\Check;
use App\Models\Company;
use App\Models\CostCenter;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ChecksIndex extends Component
{
    use WithPagination;

    public $search, $order, $date;
    public $searchNumero, $searchName, $searchPuesto, $searchEstatus, $área, $compañia;
    public $sort = 'checks.id';
    public $direction = 'desc';
    protected $paginationTheme = "bootstrap";

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
        $this->date = Carbon::now()->formatLocalized('%Y-%m-%d');
    }

    public function render()
    {

        $checks = Check::whereDate('fecha',  $this->date)
            ->join('users', 'checks.user_id', '=', 'users.id')
            ->when($this->searchNumero, function($query){
                $query->where('users.número_de_empleado', 'LIKE', '%' . $this->searchNumero . '%');
            })
            ->when($this->searchName, function($query){
                $query->where('users.name', 'LIKE', '%' . $this->searchName . '%');
            })
            ->when($this->searchPuesto, function($query){
                $query->where('users.puesto', 'LIKE', '%' . $this->searchPuesto . '%');
            })
            ->when($this->searchEstatus, function($query){
                $query->where('users.estatus', 'LIKE', '%' . $this->searchEstatus . '%');
            })
            ->when($this->área, function($query){
                $query->whereHas('user', function($query){
                    $query->whereHas('areas', function($query){
                        $query->where('area_id', $this->área);
                    });
                });
            })
            ->when($this->compañia, function($query){
                $query->where('users.company_id', $this->compañia);
            })
            ->orderBy($this->sort, $this->direction)
            ->latest('checks.id')
            ->paginate(); 
        $all_checks = Check::whereDate('fecha',  $this->date)->count();

        $areas = Area::orderBy('área')->get();

        $cost_centers = CostCenter::orderBy('folio')->get();

        $companies = Company::orderBy('nombre_de_la_compañia')->get();

        return view('livewire.admin.checks.checks-index', [
            'checks' => $checks,
            'all_checks' => $all_checks,
            'areas' => $areas,
            'cost_centers' => $cost_centers,
            'companies' => $companies,
        ]);
    }
}
