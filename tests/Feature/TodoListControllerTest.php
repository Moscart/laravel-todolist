<?php

namespace Tests\Feature;

use Database\Seeders\TodoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TodoListControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        DB::delete('delete from todos');
    }
    public function testTodoList()
    {
        $this->seed(TodoSeeder::class);
        $this->withSession([
            'user' => 'daniel',
        ])->get('/todolist')
            ->assertSeeText('1')
            ->assertSeeText('Daniel')
            ->assertSeeText('2')
            ->assertSeeText('Theo');
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            'user' => 'daniel',
        ])->post('/todolist', [])
            ->assertSeeText('Todo is required');
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            'user' => 'daniel',
        ])->post('/todolist', [
            'todo' => 'Daniel',
        ])
            ->assertRedirect('/todolist');
    }

    public function testRemoveTodoList()
    {
        $this->withSession([
            'user' => 'daniel',
            'todoList' => [
                [
                    'id' => '1',
                    'todo' => 'daniel',
                ],
                [
                    'id' => '2',
                    'todo' => 'theo',
                ]
            ]
        ])->post('/todolist/1/delete')
            ->assertRedirect('/todolist');
    }
}
