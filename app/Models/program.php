<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class program extends Model
{
    use HasFactory;
    public $table = "program";
    protected $fillable = ['sumber_dana', 'data_program', 'keterangan'];
}
