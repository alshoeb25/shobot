<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = ['name','logo','theme_color','welcome_text'];

    public function questions()
    {
        return $this->hasMany(BotQuestion::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'organization_user');
    }

}
