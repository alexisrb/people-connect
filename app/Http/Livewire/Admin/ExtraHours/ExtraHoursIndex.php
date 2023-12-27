<?php

namespace App\Http\Livewire\Admin\ExtraHours;

use App\Models\Area;
use App\Models\Company;
use App\Models\CostCenter;
use App\Models\ExtraHour;
use Livewire\Component;
use Livewire\WithPagination;

class ExtraHoursIndex extends Component
{
    use WithPagination;

    public $date;

    public $search, $order;
    public $searchNumero, $searchName, $searchPuesto, $searchEstatus, $área, $cost_center, $compañia, $estatus;
    public $sort = 'extra_hours.id';
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

    public function render()
    {
        $extraHours = ExtraHour::select('extra_hours.*')->where('fecha', 'LIKE', '%' . $this->date . '%')
                        ->join('users', 'extra_hours.user_id', '=', 'users.id')
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
                        ->when($this->cost_center, function($query){
                            $query->whereHas('user', function($query){
                                $query->where('cost_center_id', $this->cost_center);
                            });
                        })
                        ->when($this->compañia, function($query){
                            $query->where('users.company_id', $this->compañia);
                        })
                        ->when($this->estatus, function($query){
                            $query->where('extra_hours.estatus', $this->estatus);
                        })
                        ->orderBy($this->sort, $this->direction)
                        ->latest('extra_hours.id')
                        ->paginate();

        $all_extraHours = ExtraHour::where('fecha', 'LIKE', '%' . $this->date . '%')->count();

        $areas = Area::orderBy('área')->get();

        $cost_centers = CostCenter::orderBy('folio')->get();

        $companies = Company::orderBy('nombre_de_la_compañia')->get();
        
        return view('livewire.admin.extra-hours.extra-hours-index', [
            'extraHours' => $extraHours,
            'all_extraHours' => $all_extraHours,
            'areas' => $areas,
            'cost_centers' => $cost_centers,
            'companies' => $companies,
        ]);
    }
}
