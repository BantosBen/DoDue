<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Attributes\Rule;
use Livewire\Component;

class TodoApp extends Component
{

    #[Rule('required|min:3|max:50')]
    public $name;

    public function create()
    {
        //validate
        //create todo
        //clear the input
        //send flash message

        $validated = $this->validateOnly('name');

        Todo::create($validated);

        $this->reset();

        session()->flash("success", "Todo created");
    }
    public function render()
    {
        return view('livewire.todo-app');
    }
}