<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class TodoApp extends Component
{
    use WithPagination;

    #[Rule('required|min:3|max:50')]
    public $name;
    public $search;

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

    public function delete($id)
    {
        Todo::find($id)->delete();
    }

    public function toggle($id)
    {
        $todo = Todo::find($id);
        $todo->completed = !$todo->completed;
        $todo->save();
    }
    public function render()
    {
        return view(
            'livewire.todo-app',
            [
                'todos' => Todo::latest()->where('name', 'like', "%$this->search%")->paginate(5)
            ]
        );
    }
}