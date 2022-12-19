<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @OA\Schema(
 *  schema="SystemUser",
 *  title="SystemUser",
 *  required={"name","middlename","surname","email","password", "language"},
 *   @OA\Property(property="id",type="number",@OA\Schema(example="1")),
 *   @OA\Property(property="name",type="string",@OA\Schema(example="Salohiddin")),
 *   @OA\Property(property="middlename",type="string",@OA\Schema(example="Salohiddin")),
 *   @OA\Property(property="surname",type="string",@OA\Schema(example="Nuridinov")),
 *   @OA\Property(property="email",type="string",@OA\Schema(example="info@gnail.com")),
 *   @OA\Property(property="email_verified_at",type="date",@OA\Schema(example="2022-11-20")),
 *   @OA\Property(property="password",type="string",@OA\Schema(example="admin")),
 *   @OA\Property(property="phone",type="string",@OA\Schema(example="+998901234567")),
 *   @OA\Property(property="language",type="enum",@OA\Schema(example="uz")),
 *   @OA\Property(property="created_at",type="date"),
 *   @OA\Property(property="updated_at",type="date"),
 * )
 */
class SystemUser extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'middlename',
        'surname',
        'email',
        'phone',
        'language',
        'password',
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
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
