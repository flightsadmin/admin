<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\ServiceList;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceLists extends Component
{ 
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $service, $price, $service_id, $keyWord;

    public function render()
    {
        $keyWord = '%'. $this->keyWord .'%';
        $services = ServiceList::latest()
                    ->orWhere('service', 'LIKE', $keyWord)
                    ->paginate();
        return view('livewire.services.view', [
            'services' => $services
        ]);
    }
    
    public function saveService()
    {
        $validatedData = $this->validate([
            'service'   => 'required',
            'price'     => 'required|integer|min:0',
        ]);

        ServiceList::updateOrCreate(['id' => $this->service_id], $validatedData);

        $this->dispatch('closeModal');
        session()->flash('message', 'Service created successfully.');
        $this->reset();
    }

    public function edit($id)
    {
        $service = ServiceList::findOrFail($id);
        $this->service_id = $id;
        $this->service = $service->service;
        $this->price = $service->price;
    }

    public function destroy($id)
    {
        ServiceList::find($id)->delete();
        session()->flash('message', 'Service Deleted Successfully.');
    }
}