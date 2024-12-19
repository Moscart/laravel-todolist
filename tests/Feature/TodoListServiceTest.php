<?php

namespace Tests\Feature;

use App\Services\TodoListService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TodoListServiceTest extends TestCase
{
    private TodoListService $todoListService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->todoListService = $this->app->make(TodoListService::class);
    }

    public function testTodoListNotNull()
    {
        self::assertNotNull($this->todoListService);
    }

    public function testSaveTodo()
    {
        $this->todoListService->saveTodo('1', 'daniel');

        $todoList = Session::get('todoList');

        foreach ($todoList as $value) {
            self::assertEquals('1', $value['id']);
            self::assertEquals('daniel', $value['todo']);
        }
    }

    public function testGetTodoListEmpty()
    {
        self::assertEquals([], $this->todoListService->getTodoList());
    }

    public function testGetTodoListNotEmpty()
    {
        $expected = [
            [
                'id' => '1',
                'todo' => 'daniel',
            ],
            [
                'id' => '2',
                'todo' => 'theo',
            ],
        ];

        $this->todoListService->saveTodo('1', 'daniel');
        $this->todoListService->saveTodo('2', 'theo');

        self::assertEquals($expected, $this->todoListService->getTodoList());
    }
}
