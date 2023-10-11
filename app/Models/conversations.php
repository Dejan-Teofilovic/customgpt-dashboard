<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class conversations extends Model
{
    use HasFactory;
    /**
    * Get the post that owns the comment.
    */
    public function sessions()
    {
        return $this->belongsTo(Sessions::class, 'session_id', 'id');
    }

    public function prompthistories()
    {
        return $this->hasMany(prompt_histories::class, 'conversation_id', 'id');
    }
    public function promptsmetadatas()
    {
        return $this->hasMany(prompts_metadata::class, 'conversation_id', 'id');
    }
}
