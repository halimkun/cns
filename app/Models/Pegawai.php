<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';

    protected $primaryKey = 'nik';

    public $incrementing = false;

    public $timestamps = false;

    protected $keyType = 'string';

    protected $casts = [
        'nik' => 'string',
    ];

    protected $hidden = [
        'id'
    ];

    protected $guarded = ['id'];
}
