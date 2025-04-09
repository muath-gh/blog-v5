<?php

namespace App\Livewire;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WriteComment extends Component
{
    public string $content = '';
    public string $postSlug;

    protected $rules = [
        'content' => 'required|min:3|max:1000',
    ];

    public function submit()
    {
        $this->validate();

        Comment::create([
            'user_id' => Auth::id(),
            'post_slug' => $this->postSlug,
            'content' => $this->content,
        ]);

        $this->reset('content');

        $this->dispatch('notify',["detail"=>"تم اضافة التعليق بنجاح"]);
        $this->dispatch('commentAdded');
    }

    public function render()
    {
        return view('livewire.write-comment');
    }
}
