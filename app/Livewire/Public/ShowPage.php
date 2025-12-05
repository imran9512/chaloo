<?php

namespace App\Livewire\Public;

use App\Models\Page;
use Livewire\Component;
use Illuminate\Support\Facades\Route;

class ShowPage extends Component
{
    public Page $page;

    public function mount()
    {
        // Get the slug from the current route path, removing the leading slash
        $slug = ltrim(request()->path(), '/');

        // Handle edge case where route might be defined differently or we want to be explicit
        // But since we will define specific routes for each page pointing to this component,
        // or a catch-all, we need to be careful.

        // Actually, a better way for the specific routes I created earlier is to pass the slug via the route parameter if I used a controller,
        // but since I'm using Livewire directly in the route, I can't easily pass a static slug unless I use a wrapper or change the route definition.

        // Let's change the strategy:
        // I will keep the specific routes in web.php but point them to this component.
        // And I will use the route name or path to determine the page.

        // However, the cleanest way for "dynamic" pages is usually a catch-all route `{slug}`.
        // But the user wants the specific pages I just created (About, Contact, etc.) to be editable.
        // These have specific URLs.

        // So I will look up the page by the current URI.
        $this->page = Page::where('slug', $slug)->where('is_published', true)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.public.show-page')->layout('layouts.public');
    }
}
