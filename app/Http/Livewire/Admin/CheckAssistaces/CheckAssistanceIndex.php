<?php

namespace App\Http\Livewire\Admin\CheckAssitances;

use App\Models\Area;
use App\Models\CheckAssistance;
use App\Models\Company;
use Livewire\Component;
use Livewire\WithPagination;

class CheckAssistanceIndex extends Component
{
    use WithPagination;
    public $search, $order, $date;
    public $sort = 'id';
    public $direction = 'desc';
    protected $paginationTheme = "bootstrap";

    public $searchName, $área, $compañia;

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
        $check = CheckAssistance::when($this->searchName, function($query){
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
        ->orderBy($this->sort, $this->direction)
        ->latest('id')
        ->paginate();
        $areas = Area::orderBy('área')->get();

        $companies = Company::orderBy('nombre_de_la_compañia')->get();
        return view('livewire.admin.check-assistances.check-assistances-index', [
            'check' => $check,
            'areas' => $areas,
            'companies' => $companies,
        ]);
    }
}