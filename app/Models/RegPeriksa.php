<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegPeriksa extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $connection = 'mysql';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reg_periksa';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'no_rawat';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Indicates if the model should be incrementing.
     * 
     * @var bool
     * */
    public $incrementing = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'no_rawat' => 'string',
        'no_rkm_medis' => 'string',
    ];


    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'no_rkm_medis', 'no_rkm_medis');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }

    public function spesialis()
    {
        return $this->hasOneThrough(
            Spesialis::class,
            Dokter::class,
            'kd_dokter', // Foreign key on Dokter table
            'kd_sps',    // Foreign key on Spesialis table
            'kd_dokter', // Local key on RegPeriksa table
            'kd_sps'     // Local key on Dokter table
        );
    }

    public function poli()
    {
        return $this->belongsTo(Poliklinik::class, 'kd_poli', 'kd_poli');
    }

    public function jadwal_dokter()
    {
        $hari = \Carbon\Carbon::parse($this->tgl_registrasi)->locale('id')->isoFormat('dddd');
        return $this->belongsTo(JadwalPoliklinik::class, ['kd_dokter', 'kd_poli'], ['kd_dokter', 'kd_poli'])
            ->where('hari_kerja', $hari);
    }

    public function sep()
    {
        return $this->hasOne(BridgingSep::class, 'no_rawat', 'no_rawat');
    }
}
