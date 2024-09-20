<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'student';

    // Para indicar que campos podran ser alterados
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'language'
    ];

}
