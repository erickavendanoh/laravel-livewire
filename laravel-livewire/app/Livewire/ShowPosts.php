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
        $posts = Post::all();

        return view('livewire.show-posts', compact('posts'))
                ->layout('layouts.app');
    }
}
