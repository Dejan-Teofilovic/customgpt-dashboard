<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prompt_conversation_debug_info extends Model
{
    use HasFactory;

    public function prompthistories()
    {
        $this->belongsTo(prompt_histories::class, 'prompt_histories_id', 'id');
    }
}
