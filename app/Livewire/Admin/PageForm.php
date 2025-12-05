<?php

namespace App\Livewire\Admin;

use App\Models\Page;
use Livewire\Component;
use Illuminate\Support\Str;

class PageForm extends Component
{
    public Page $page;
    public $title;
    public $slug;
    public $content;
    public $is_published = true;

    public function mount(Page $page = null)
    {
        $this->page = $page ?? new Page();
        if ($this->page->exists) {
            $this->title = $this->page->title;
            $this->slug = $this->page->slug;
            $this->content = $this->page->content;
            $this->is_published = $this->page->is_published;
        }
    }

    public function updatedTitle($value)
    {
        if (!$this->page->exists) {
            $this->slug = Str::slug($value);
        }
    }

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $this->page->id,
            'content' => 'nullable|string',
            'is_published' => 'boolean',
        ];
    }

    public function save()
    {
        $this->validate();

        $this->page->fill([
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'is_published' => $this->is_published,
        ]);

        $this->page->save();

        session()->flash('message', 'Page saved successfully.');

        return redirect()->route('admin.pages');
    }

    public function render()
    {
        return view('livewire.admin.page-form')->layout('layouts.app');
    }
}
