<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Morningnews extends Model
{
    use HasFactory;
    // Змінена назва таблиці
    protected $table = 'morning_news';

    protected $fillable = ['title', 'news_text'];
}
