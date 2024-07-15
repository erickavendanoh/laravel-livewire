<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Post;

class ShowPosts extends Component
{
    public $search;
    
    public function render()
    {
        $posts = Post::where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%')
                    ->get();

        return view('livewire.show-posts', compact('posts'))
                ->layout('layouts.app');
    }
}
