<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * @OA\Get(
     *     path="/members",
     *     summary="Get list of members with borrowed books count",
     *     @OA\Response(
     *         response=200,
     *         description="A list of members with borrowed books count",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Member"),
     *             example={
     *                 {
     *                     "code": "M001",
     *                     "name": "Angga"
     *                 },
     *                 {
     *                     "code": "M002",
     *                     "name": "Ferry"
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
        $members = Member::withCount(['borrowings' => function ($query) {
            $query->whereNull('returned_at');
        }])->get(['code', 'name']);
        return response()->json([
            'success' => true,
            'data' => $members,
        ], 200);
    }
}
