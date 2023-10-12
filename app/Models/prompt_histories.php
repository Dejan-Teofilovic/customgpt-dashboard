<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prompt_histories extends Model
{
    use HasFactory;

    /**
     * Get the conversations that owns the prompt.
     */
    public function conversations()
    {
        return $this->belongsTo(conversations::class, 'conversation_id', 'id');
    }

    public function conversationDebugInfos()
    {
        return $this->hasMany(prompt_conversation_debug_info::class, 'prompt_histories_id', 'id');
    }
    public function prompts_metadata()
    {
        return $this->hasMany(prompts_metadata::class, 'prompt_history_id', 'id');
    }
}
