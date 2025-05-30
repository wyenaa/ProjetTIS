<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    protected $table = 'classes';
    protected $fillable = [
        'user_id',
        'nama_kelas',
        'mata_pelajaran',
        'nama_pengajar',
        'jadwal',
        'deskripsi',
    ];

    /**
     * Parse jadwal string ke dalam array untuk pengurutan
     */
    public function parseJadwal()
    {
        $parts = explode(', ', $this->jadwal);
        $hari = $parts[0];
        $jam = explode('-', trim($parts[1]));
        return [
            'hari' => $hari,
            'jam_mulai' => $jam[0],
            'jam_selesai' => $jam[1]
        ];
    }
    
    public function user(){
    return $this->belongsTo(User::class);
    }

}