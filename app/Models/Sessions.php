<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sessions extends Model
{
    use HasFactory;

    /**
     * Get the conversations that owns the session.
     */
    public function conversations()
    {
        return $this->hasMany(conversations::class, 'session_id');
    }
}
