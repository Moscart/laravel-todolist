<?php

namespace Tests\Feature;

use App\Services\TodoListService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Testing\Assert;
use Tests\TestCase;

class TodoListServiceTest extends TestCase
{
    private TodoListService $todoListService;

    protected function setUp(): void
    {
        parent::setUp();

        DB::delete('delete from todos');
        DB::delete('delete from users');

        $this->todoListService = $this->app->make(TodoListService::class);
    }

    public function testTodoListNotNull()
    {
        self::assertNotNull($this->todoListService);
    }

    public function testSaveTodo()
    {
        $this->todoListService->saveTodo('1', 'Daniel');

        $todoList = $this->todoListService->getTodoList();

        foreach ($todoList as $value) {
            self::assertEquals('1', $value['id']);
            self::assertEquals('Daniel', $value['todo']);
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

        Assert::assertArraySubset($expected, $this->todoListService->getTodoList());
    }

    public function testRemoveTodo()
    {
        $this->todoListService->saveTodo('1', 'daniel');
        $this->todoListService->saveTodo('2', 'theo');

        self::assertEquals(2, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodo('3');

        self::assertEquals(2, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodo('1');

        self::assertEquals(1, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodo('2');

        self::assertEquals(0, sizeof($this->todoListService->getTodoList()));
    }
}
