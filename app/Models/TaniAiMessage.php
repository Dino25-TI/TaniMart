<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaniAiMessage extends Model
{
    protected $table = 'tani_ai_messages';

    protected $fillable = [
        'role',
        'content',
    ];

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(
            TaniAiConversation::class,
            'conversation_id'
        );
    }
}
