<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *  schema="PostJoinFile",
 *  title="PostJoinFile",
 *  required={"post_id","file_id"},
 *   @OA\Property(property="id",type="number",@OA\Schema(example="1")),
 *   @OA\Property(property="post_id",type="number",@OA\Schema(example="1")),
 *   @OA\Property(property="file_id",type="number",@OA\Schema(example="1")),
 *   @OA\Property(property="created_at",type="date"),
 *   @OA\Property(property="updated_at",type="date"),
 * )
 */
class PostJoinFile extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'post_id',
        'file_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
