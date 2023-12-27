<?php

namespace App\Http\Livewire\Admin\Admonitions;

use App\Models\Admonition;
use Livewire\Component;
use Livewire\WithPagination;

class AdmonitionsIndex extends Component
{
    use WithPagination;

    public $search, $order;
    public $sort = 'id';
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
        $admonitions = Admonition::
                        orderBy($this->sort, $this->direction)
                        ->latest('id')
                        ->paginate();
        
        $all_admonitions = Admonition::count();

        return view('livewire.admin.admonitions.admonitions-index', [
            'admonitions' => $admonitions,
            'all_admonitions' => $all_admonitions
        ]);
    }
}
