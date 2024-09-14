<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="Library API", version="1.0.0")
 */
class BookController extends Controller
{
    /**
     * @OA\Get(
     *     path="/books",
     *     summary="Get list of available books",
     *     @OA\Response(
     *         response=200,
     *         description="A list of available books",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Book"),
     *             example={
     *                 {
     *                     "code": "JK-45",
     *                     "title": "Harry Potter",
     *                     "author": "J.K Rowling",
     *                     "stock": 1
     *                 },
     *                 {
     *                     "code": "SHR-1",
     *                     "title": "A Study in Scarlet",
     *                     "author": "Arthur Conan Doyle",
     *                     "stock": 1
     *                 }
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function index()
    {
        $borrowedBookIds = Borrowing::whereNull('returned_at')->pluck('book_id');
        $books = Book::whereNotIn('id', $borrowedBookIds)->get(['code', 'title', 'author', 'stock']);
        return response()->json([
            'success' => true,
            'data' => $books,
        ], 200);
    }
}
