<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;
    protected $fillable = ['member_id', 'book_id', 'borrowed_at', 'due_at', 'returned_at'];

    public function returnBook()
    {
        $this->returned_at = now();
        $this->save();

        if (now()->greaterThan($this->due_at)) {
            Penalty::create([
                'member_id' => $this->member_id,
                'penalty_start' => now(),
                'penalty_end' => now()->addDays(3),
            ]);
        }
    }
}
