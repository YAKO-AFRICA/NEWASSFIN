<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TblVille extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'tblville';

    protected $fillable = [
        'IdTblVille',
        'CodeVille',
        'MonLibelle',
        'CodeDepartement'
    ];
    // Désactiver les timestamps
    public $timestamps = false;
    protected $primaryKey = 'idville';

    
}
