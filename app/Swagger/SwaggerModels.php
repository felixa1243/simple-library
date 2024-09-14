<?php

namespace App\Swagger;

/**
 * @OA\Schema(
 *     schema="Book",
 *     type="object",
 *     @OA\Property(property="code", type="string", example="JK-45"),
 *     @OA\Property(property="title", type="string", example="Harry Potter"),
 *     @OA\Property(property="author", type="string", example="J.K Rowling"),
 *     @OA\Property(property="stock", type="integer", example=1)
 * )
 */

class SwaggerModels
{
}

/**
 * @OA\Schema(
 *     schema="Member",
 *     type="object",
 *     @OA\Property(property="code", type="string", example="M001"),
 *     @OA\Property(property="name", type="string", example="Angga")
 * )
 */

class MemberModels
{
}
