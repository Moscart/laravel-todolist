<?php

namespace App\Http\Controllers;

use App\Services\TodoListService;
use Illuminate\Http\Request;

class TodoListController extends Controller
{
    private TodoListService $todoListService;

    public function __construct(TodoListService $todoListService)
    {
        $this->todoListService = $todoListService;
    }

    public function todoList(Request $request)
    {
        $todoList = $this->todoListService->getTodoList();

        return response()->view('todolist.todolist', [
            'title' => 'TodoList',
            'todoList' => $todoList
        ]);
    }

    public function addTodo(Request $request) {}

    public function removeTodo(Request $request, string $todoId) {}
}
