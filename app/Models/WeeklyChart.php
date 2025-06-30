<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyChart extends Model
{
    protected $fillable=['days','deposit','withdraw'];
}
