<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
/**
 * @OA\Schema(
 *  schema="User",
 *  title="User",
 *  required={"name","middlename","surname","phone", "language", "code"},
 *   @OA\Property(property="id",type="number",@OA\Schema(example="1")),
 *   @OA\Property(property="name",type="string",@OA\Schema(example="Salohiddin")),
 *   @OA\Property(property="middlename",type="string",@OA\Schema(example="Salohiddin")),
 *   @OA\Property(property="surname",type="string",@OA\Schema(example="Nuridinov")),
 *   @OA\Property(property="phone",type="string",@OA\Schema(example="+998901234567")),
 *   @OA\Property(property="language",type="string",@OA\Schema(example="uz")),
 *   @OA\Property(property="code",type="number",@OA\Schema(example="1425")),
 *   @OA\Property(property="created_at",type="date"),
 *   @OA\Property(property="updated_at",type="date"),
 * )
 */
class User extends Model
{
    use HasApiTokens, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'middlename',
        'surname',
        'phone',
        'language',
        'code',
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
