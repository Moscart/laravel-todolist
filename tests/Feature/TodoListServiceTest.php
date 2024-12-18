<?php

namespace Tests\Feature;

use App\Services\TodoListService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
}
