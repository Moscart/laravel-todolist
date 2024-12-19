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

    public function addTodo(Request $request)
    {
        $todo = $request->input('todo');

        if (empty($todo)) {
            $todoList = $this->todoListService->getTodoList();
            return response()->view('todolist.todolist', [
                'title' => 'TodoList',
                'todoList' => $todoList,
                'error' => 'Todo is required'
            ]);
        }

        $this->todoListService->saveTodo(uniqid(), $todo);

        return redirect()->action([TodoListController::class, 'todoList']);
    }

    public function removeTodo(Request $request, string $todoId)
    {
        $this->todoListService->removeTodo($todoId);

        return redirect()->action([TodoListController::class, 'todoList']);
    }
}
