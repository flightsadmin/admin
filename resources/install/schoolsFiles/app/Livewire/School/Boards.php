<?php

namespace App\Livewire\School;

use App\Models\Board;
use Livewire\Component;
use Livewire\WithPagination;

class Boards extends Component
{ 
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $board_id, $title, $body, $keyWord;

    public function render()
    {
        $keyWord = '%'. $this->keyWord .'%';
        $boards = Board::latest()
                    ->orWhere('title', 'LIKE', $keyWord)
                    ->paginate();
        return view('livewire.admin.school.boards.view', [
            'boards' => $boards
        ])->extends('components.layouts.admin');
    }
    
    public function save()
    {
        $validatedData = $this->validate([
            'title' => 'required',
            'body'  => 'required|min:10'
        ]);
        $validatedData['user_id'] = auth()->user()->id;

        Board::updateOrCreate(['id' => $this->board_id], $validatedData);

        $this->alert();
        $this->reset();
    }

    public function edit($id)
    {
        $board = Board::findOrFail($id);
        $this->board_id = $id;
        $this->title = $board->title;
        $this->body = $board->body;
    }

    public function details($id) {
        $board = Board::findOrFail($id);
        return view('livewire.admin.school.boards.details', [
            'board' => $board
        ]);
    }

    public function alert() {
        $this->dispatch(
            'closeModal',
            icon: "success",
            message: $this->board_id ? 'Board Updated Successfully.' : 'Board Created Successfully.',
        );
    }

    public function destroy($id)
    {
        Board::findOrFail($id)->delete();
        $this->dispatch(
            'closeModal',
            icon: "success",
            message: "Board Updated Successfully.",
        );
    }
}