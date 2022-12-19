<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *  schema="PostCategory",
 *  title="PostCategory",
 *  required={"name_uz","name_ru","name_eng"},
 *   @OA\Property(property="id",type="number",@OA\Schema(example="1")),
 *   @OA\Property(property="name_uz",type="string",@OA\Schema(example="Uzbek")),
 *   @OA\Property(property="name_ru",type="string",@OA\Schema(example="Russian")),
 *   @OA\Property(property="name_eng",type="string",@OA\Schema(example="English")),
 *   @OA\Property(property="created_at",type="date"),
 *   @OA\Property(property="updated_at",type="date"),
 * )
 */ 
class PostCategory extends Model
{
    use HasFactory;
    /*
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_uz',
        'name_ru',
        'name_eng',
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
