<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Borrowing;
use Illuminate\Http\Request;
class BorrowingController extends Controller
{
    /**
     * @OA\Post(
     *     path="/borrow",
     *     summary="Borrow a book",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="member_id", type="integer", example=1),
     *             @OA\Property(property="book_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book borrowed successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Book borrowed successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error in borrowing book",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid member or book.")
     *         )
     *     )
     * )
     */
    public function borrow(Request $request)
    {
        $member = Member::find($request->member_id);
        $book = Book::find($request->book_id);

        if (!$book || !$member) {
            return response()->json(['error' => 'Invalid member or book.'], 400);
        }

        if (!$book->isAvailable()) {
            return response()->json(['error' => 'Book is not available.'], 400);
        }

        if (!$member->canBorrow()) {
            return response()->json(['error' => 'Member cannot borrow more books.'], 400);
        }

        // Borrow book
        $book->decrement('stock');
        Borrowing::create([
            'member_id' => $member->id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_at' => now()->addDays(7),
        ]);

        return response()->json(['message' => 'Book borrowed successfully']);
    }

    /**
     * @OA\Post(
     *     path="/return",
     *     summary="Return a borrowed book",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="member_id", type="integer", example=1),
     *             @OA\Property(property="book_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book returned successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Book returned successfully")
     *         )
     *     )
     * )
     */
    public function returnBook(Request $request)
    {
        $borrowing = Borrowing::where('member_id', $request->member_id)
            ->where('book_id', $request->book_id)
            ->whereNull('returned_at')
            ->first();

        if (!$borrowing) {
            return response()->json(['error' => 'No active borrowing found.'], 400);
        }

        $borrowing->returnBook();

        // Increment stock
        $book = Book::find($request->book_id);
        $book->increment('stock');

        return response()->json(['message' => 'Book returned successfully']);
    }
}
