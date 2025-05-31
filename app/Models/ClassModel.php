<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ClassModel
 *
 * @property int $id
 * @property int $user_id
 * @property string $nama_kelas
 * @property string $mata_pelajaran
 * @property string $nama_pengajar
 * @property string $jadwal
 * @property string|null $deskripsi
 * @property \App\Models\User $user
 */
class ClassModel extends Model
{
    protected $table = 'classes';

=======

class ClassModel extends Model
{
    protected $table = 'classes';
>>>>>>> ab45104df30133a776c37302ffe0fec01274cd77
    protected $fillable = [
        'user_id',
        'nama_kelas',
        'mata_pelajaran',
        'nama_pengajar',
        'jadwal',
        'deskripsi',
    ];

    /**
<<<<<<< HEAD
     * Parse jadwal string (format: "Hari, HH:MM-HH:MM") ke array
     *
     * @return array{hari: string, jam_mulai: string, jam_selesai: string}
     */
    public function parseJadwal(): array
    {
        $parts = explode(', ', $this->jadwal);
        $hari = $parts[0] ?? '';
        $jam = isset($parts[1]) ? explode('-', $parts[1]) : ['00:00', '00:00'];

        return [
            'hari' => $hari,
            'jam_mulai' => $jam[0] ?? '00:00',
            'jam_selesai' => $jam[1] ?? '00:00',
        ];
    }

    /**
     * Relasi ke model User
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
=======
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

>>>>>>> ab45104df30133a776c37302ffe0fec01274cd77
}