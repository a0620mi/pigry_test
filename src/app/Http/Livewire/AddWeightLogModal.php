<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\WeightLog;
use Illuminate\Support\Facades\Auth;

class AddWeightLogModal extends Component
{
    public $showModal = false;

    public $date;
    public $weight;
    public $calories;
    public $exercise_time;

    protected $listeners = ['openModalEvent' => 'openModal'];

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetErrorBag();
    }

    protected $rules = [
        'date' => 'required|date',
        'weight' => 'required|numeric|min:0',
        'calories' => 'nullable|integer|min:0',
        'exercise_time' => 'nullable|date_format:H:i',
    ];

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->date = now()->format('Y-m-d');
        $this->weight = null;
        $this->calories = null;
        $this->exercise_time = '00:00';
    }
    /**
    *
    *@param bool $isOpen
    */
    public function save()
    {
        $this->validate();

        WeightLog::create([
            'user_id' => Auth::id(),
            'date' => $this->date,
            'weight' => $this->weight,
            'calories' => $this->calories ?? 0,
            'exercise_time' => $this->exercise_time ? $this->exercise_time . ':00' : '00:00:00',
        ]);

        $this->closeModal();
        $this->emit('logAddedAndRefresh');
    }

    public function render()
    {
        return view('livewire.add-weight-log-modal');
    }
}
