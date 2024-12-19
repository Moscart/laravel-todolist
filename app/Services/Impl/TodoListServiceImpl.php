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

    public function getTodoList(): array
    {
        return Session::get('todoList', []);
    }

    public function removeTodo(string $todoId)
    {
        $todoList = Session::get('todoList');

        foreach ($todoList as $index => $value) {
            if ($value['id'] == $todoId) {
                unset($todoList[$index]);
                break;
            }
        }

        Session::put('todoList', $todoList);
    }
}
