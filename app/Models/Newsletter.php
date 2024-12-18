<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'process_status',
        'send_at',
        'scheduled_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'newsletter_user')
            ->withPivot('is_sent');
    }

    public function sentUsers()
    {
        return $this->belongsToMany(User::class, 'newsletter_user')
            ->withPivot('is_sent')
            ->wherePivot('is_sent', true);
    }

}
