<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class conversations extends Model
{
    use HasFactory;

    public function prompthistories()
    {
        return $this->hasMany(prompt_histories::class, 'conversation_id', 'id')->orderBy('created_at', 'asc');
    }
    // public function promptsmetadatas()
    // {
    //     return $this->hasMany(prompts_metadata::class, 'conversation_id', 'id');
    // }
}
