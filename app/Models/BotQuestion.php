<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['organization_id','question_text', 'field_name', 'type', 'options', 'parent_id', 'order'];
    protected $casts = ['options' => 'array'];

    public function subQuestions()
    {
        return $this->hasMany(BotQuestion::class, 'parent_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}

