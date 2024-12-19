<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListControllerTest extends TestCase
{
    public function testTodoList()
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
        ])->get('/todolist')
            ->assertSeeText('1')
            ->assertSeeText('daniel')
            ->assertSeeText('2')
            ->assertSeeText('theo');
    }
}
