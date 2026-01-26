<?php

namespace App\Models; 



use Illuminate\Database\Eloquent\Model;
use App\Models\ChatMessage;

class ChatSession extends Model
{
    
    protected $fillable = ['session_token', 'user_id','user_ip'];
    
    public function messages() 
    {
        return $this->hasMany(ChatMessage::class);
    }

}
