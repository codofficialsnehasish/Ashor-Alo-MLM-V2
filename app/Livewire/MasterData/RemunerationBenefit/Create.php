<?php

namespace App\Livewire\MasterData\RemunerationBenefit;

use Livewire\Component;
use App\Models\RemunerationBenefitMaster;

class Create extends Component
{
    public $rank_name, $matching_target, $bonus, $month_validity, $is_visible = false;

    protected $rules = [
        'rank_name' => 'required|string|max:255',
        'matching_target' => 'required|numeric',
        'bonus' => 'required|numeric',
        'month_validity' => 'required|integer',
    ];

    public function save()
    {
        $this->validate();

        RemunerationBenefitMaster::create([
            'rank_name' => $this->rank_name,
            'matching_target' => $this->matching_target,
            'bonus' => $this->bonus,
            'month_validity' => $this->month_validity,
            'is_visible' => $this->is_visible ? 1 : 0,
        ]);

        session()->flash('success', 'Created successfully.');
        return redirect()->route('remuneration-benefit.index');
    }

    public function render()
    {
        return view('livewire.master-data.remuneration-benefit.create');
    }
}
