<?php

namespace App\Livewire\Admin;

use App\Models\Page;
use Livewire\Component;
use Livewire\WithPagination;

class ManagePages extends Component
{
    use WithPagination;

    public function delete($id)
    {
        Page::find($id)->delete();
        session()->flash('message', 'Page deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.manage-pages', [
            'pages' => Page::latest()->paginate(10),
        ])->layout('layouts.app');
    }
}
