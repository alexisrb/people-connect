<?php

namespace App\Http\Livewire\Admin\ExtraOrdinariesHours;

use App\Models\Area;
use App\Models\Company;
use App\Models\CostCenter;
use App\Models\ExtraordinaryOvertime;
use Livewire\Component;
use Livewire\WithPagination;

class ExtraOrdinariesIndex extends Component
{
      use WithPagination;
      public $searchNumero, $searchName, $searchPuesto, $searchEstatus, $área, $cost_center, $compañia, $estatus;
      public $sort = 'id';
      public $direction = 'desc';
      
      public function updatingSearch(){
            $this->resetPage();
      }

      public function render()
      {
            $all_extraordinaries = ExtraordinaryOvertime::select('extraordinary_overtimes.*')
                  ->join('users', 'extraordinary_overtimes.user_id', '=', 'users.id')
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
                  $query->where('extraordinary_overtimes.estatus', $this->estatus);
                  })
                  ->latest('extraordinary_overtimes.id')
                  ->paginate();
            
            $areas = Area::orderBy('área')->get();

            $cost_centers = CostCenter::orderBy('folio')->get();
      
            $companies = Company::orderBy('nombre_de_la_compañia')->get();
            
            return view('livewire.admin.extraordinaries_overtimes.extraordinaries-index', [
                  'all_extraordinaries' => $all_extraordinaries,
                  'areas' => $areas,
                  'cost_centers' => $cost_centers,
                  'companies' => $companies
            ]);
      }
}