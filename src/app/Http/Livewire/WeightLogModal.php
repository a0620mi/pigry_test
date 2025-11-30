<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\WeightLog;

class WeightLogModal extends Component
{
    protected $listeners = ['openLogModal' => 'openModal'];

    public $showModal = false;

    public $log = null;
    /**
     *
     * @param int $logId
     */

    public function openModal($logId)
    {
        $this->log = WeightLog::find($logId);

        if ($this->log){
            $this->showModal = true;
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->log = null;
    }

    public function render()
    {
        return view('livewire.weight-log-modal');
    }
}
