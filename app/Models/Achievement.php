<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Achievement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'habit_id',
        'name',
        'start_date',
        'completion_date',
        'target_days',
        'checked_days_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'completion_date' => 'date',
    ];

    /**
     * Get the user that earned the achievement.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the habit associated with the achievement.
     */
    public function habit(): BelongsTo
    {
        return $this->belongsTo(Habit::class);
    }
}
