<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class UserInfo extends Model
{
    use HasFactory;

    protected $table = 'user_infos';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}