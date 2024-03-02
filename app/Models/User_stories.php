<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class User_stories extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'details', 'acceptance_criteria', 'status','project_id'];

    // Relación con el proyecto
    public function project()
    {
        return $this->belongsTo(Projects::class);
    }
}
