<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['description', 'status', 'user_story_id','assigned_to','updated_by'];

    public function userStory()
    {
        return $this->belongsTo(User_stories::class);
    }
}
