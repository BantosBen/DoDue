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
    public $todoID;

    #[Rule('required|min:3|max:50')]
    public $newName;

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

        $this->resetPage();
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

    public function edit($id)
    {
        $this->todoID = $id;
        $this->newName = Todo::find($id)->name;
    }

    public function cancelEdit()
    {
        $this->reset('todoID', 'newName');
    }

    public function update()
    {
        $this->validateOnly('newName');
        Todo::find($this->todoID)->update(
            [
                'name' => $this->newName
            ]
        );
        $this->cancelEdit();
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