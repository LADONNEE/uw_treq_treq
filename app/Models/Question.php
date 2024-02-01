<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
protected $fillable = [
      'question','notes','question_type','options','status','label','item'
    ];
}
