<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Member;
use App\Models\Borrowing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BorrowingTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_can_borrow_book()
    {
        $member = Member::factory()->create();
        $book = Book::factory()->create(['stock' => 1]);

        $response = $this->post('/borrow', [
            'member_id' => $member->id,
            'book_id' => $book->id,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('borrowings', ['member_id' => $member->id, 'book_id' => $book->id]);
        $this->assertDatabaseHas('books', ['id' => $book->id, 'stock' => 0]);
    }

    public function test_member_cannot_borrow_if_book_unavailable()
    {
        $member = Member::factory()->create();
        $book = Book::factory()->create(['stock' => 0]);

        $response = $this->post('/borrow', [
            'member_id' => $member->id,
            'book_id' => $book->id,
        ]);

        $response->assertStatus(400);
        $this->assertDatabaseMissing('borrowings', ['member_id' => $member->id, 'book_id' => $book->id]);
    }

    public function test_member_can_return_book()
    {
        $member = Member::factory()->create();
        $book = Book::factory()->create(['stock' => 0]);

        $borrowing = Borrowing::create([
            'member_id' => $member->id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_at' => now()->addDays(7),
        ]);

        $response = $this->post('/return', [
            'member_id' => $member->id,
            'book_id' => $book->id,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('borrowings', ['id' => $borrowing->id, 'returned_at' => now()]);
        $this->assertDatabaseHas('books', ['id' => $book->id, 'stock' => 1]);
    }
}
