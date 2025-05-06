<?php

namespace App\Livewire\MasterData\RemunerationBenefit;

use Livewire\Component;
use App\Models\RemunerationBenefitMaster;

class Edit extends Component
{
    public $itemId;
    public $rank_name, $matching_target, $bonus, $month_validity, $is_visible = false;

    public function mount($id)
    {
        $item = RemunerationBenefitMaster::findOrFail($id);
        $this->itemId = $id;
        $this->rank_name = $item->rank_name;
        $this->matching_target = $item->matching_target;
        $this->bonus = $item->bonus;
        $this->month_validity = $item->month_validity;
        $this->is_visible = (bool) $item->is_visible;
    }

    protected $rules = [
        'rank_name' => 'required|string|max:255',
        'matching_target' => 'required|numeric',
        'bonus' => 'required|numeric',
        'month_validity' => 'required|integer',
    ];

    public function update()
    {
        $this->validate();

        RemunerationBenefitMaster::where('id', $this->itemId)->update([
            'rank_name' => $this->rank_name,
            'matching_target' => $this->matching_target,
            'bonus' => $this->bonus,
            'month_validity' => $this->month_validity,
            'is_visible' => $this->is_visible ? 1 : 0,
        ]);

        session()->flash('success', 'Updated successfully.');
        return redirect()->route('remuneration-benefit.index');
    }

    public function render()
    {
        return view('livewire.master-data.remuneration-benefit.edit');
    }
}
