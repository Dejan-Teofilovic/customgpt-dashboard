<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prompts_metadata extends Model
{
    use HasFactory;
    protected $table = 'prompts_metadata'; // Specify the custom table name
    // public function conversations()
    // {
    //     $this->belongsTo(conversations::class, 'conversation_id', 'id');
    // }
    // public function prompt_histories()
    // {
    //     $this->belongsTo(prompt_histories::class, 'prompt_history_id', 'id');
    // }
}
