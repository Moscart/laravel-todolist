<?php

namespace App\Services\Impl;

use App\Services\TodoListService;
use Illuminate\Support\Facades\Session;

class TodoListServiceImpl implements TodoListService
{

    public function saveTodo(string $id, string $todo): void
    {
        if (!Session::exists('todoList')) {
            Session::put('todoList', []);
        }

        Session::push('todoList', [
            'id' => $id,
            'todo' => $todo,
        ]);
    }
}
