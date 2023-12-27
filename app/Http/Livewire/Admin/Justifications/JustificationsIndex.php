<?php

namespace App\Http\Livewire\Admin\Justifications;

use App\Models\Area;
use App\Models\Assistance;
use App\Models\Company;
use App\Models\JustifyAttendance;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class JustificationsIndex extends Component
{
      use WithPagination;
      public $date, $from, $to;
      public $searchName, $área, $compañia, $estatus;
      public $sort = 'id';
      public $direction = 'desc';

      public function updatingSearch(){
            $this->resetPage();
      }

      public function __construct()
      {
            $hoy = Carbon::now();
            $this->date = $hoy->format('Y-m-d');
            $this->from = $hoy->format('Y-m-d');
            $this->to = $hoy->format('Y-m-d');
      }
      public function render()
      {
            $justifications = JustifyAttendance::whereDate('created_at', '=' , Carbon::now()->formatLocalized($this->date))
            ->when($this->searchName, function($query){
                  $query->whereHas('assistance', function($query){      
                        $query->whereHas('user', function($query){
                              $query->where('name', 'LIKE', '%' . $this->searchName . '%');
                        });
                  });
            })
            ->when($this->área, function($query){
                  $query->whereHas('assistance', function($query){       
                        $query->whereHas('user', function($query){
                              $query->whereHas('areas', function($query){
                                    $query->where('area_id', $this->área);
                              });
                        });
                  });
            })
            ->when($this->compañia, function($query){
                  $query->whereHas('assistance', function($query){
                        $query->whereHas('user', function($query){
                              $query->where('company_id', $this->compañia);
                        });
                  });
            })
            ->when($this->estatus, function($query){
            $query->where('estatus', $this->estatus);
            })

            ->orderBy($this->sort, $this->direction)
            ->latest('id')
            ->paginate();
            $areas = Area::orderBy('área')->get();
            $companies = Company::orderBy('nombre_de_la_compañia')->get();
            $all_justifications = JustifyAttendance::whereDate('created_at', '=' , Carbon::now()->formatLocalized($this->date))->count();
            return view('livewire.admin.justifications.justifications-index', [
                  'justifications' => $justifications,
                  'all_justifications' => $all_justifications,
                  'areas' => $areas,
                  'companies' => $companies
            ]);
      }
}