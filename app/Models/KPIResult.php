<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KPIResult extends Model
{
    protected $table = 'kpi_results';
    protected $fillable = ['tipo', 'valor'];
}
