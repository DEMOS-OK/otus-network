<?php

declare(strict_types=1);

namespace App\SocialNetwork\Infrastructure\Repositories\Eloquent\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $date_of_birth
 * @property string $gender
 * @property string $about
 * @property string $city
 * @property int $user_id
 */
final class UserInfo extends Model
{
    use HasFactory;

    protected $table = 'user_infos';

    protected $fillable = [
        'firstname',
        'lastname',
        'date_of_birth',
        'city',
        'about',
        'gender',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}