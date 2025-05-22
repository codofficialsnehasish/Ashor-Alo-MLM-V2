<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Notice;

class NoticeBoard extends Component
{
    public $notices, $title, $content, $start_date, $end_date, $is_active = true;
    public $notice_id;
    public $isOpen = false;

    public function render()
    {
        $this->notices = Notice::orderBy('created_at', 'desc')->get();
        return view('livewire.notice-board');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->title = '';
        $this->content = '';
        $this->start_date = '';
        $this->end_date = '';
        $this->is_active = true;
        $this->notice_id = '';
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'content' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Notice::updateOrCreate(['id' => $this->notice_id], [
            'title' => $this->title,
            'content' => $this->content,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'is_active' => $this->is_active,
        ]);

        // session()->flash('message', 
        //     $this->notice_id ? 'Notice Updated Successfully.' : 'Notice Created Successfully.');
        $this->dispatch('toastMessage', json_encode([
            'type'=>'success',
            'message' => $this->notice_id ? 'Notice Updated Successfully.' : 'Notice Created Successfully.'
        ]));

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $notice = Notice::findOrFail($id);
        $this->notice_id = $id;
        $this->title = $notice->title;
        $this->content = $notice->content;
        $this->start_date = $notice->start_date->format('Y-m-d');
        $this->end_date = $notice->end_date->format('Y-m-d');
        $this->is_active = $notice->is_active;
        
        $this->openModal();
    }

    public function delete($id)
    {
        Notice::find($id)->delete();
        $this->dispatch('toastMessage', json_encode([
            'type'=>'success',
            'message' => 'Notice Deleted Successfully.'
        ]));
    }

    public function toggleStatus($id)
    {
        $notice = Notice::find($id);
        $notice->is_active = !$notice->is_active;
        $notice->save();
    }
}
