<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;


    protected $fillable = [
        'nomor_induk',
        'nama',
        'alamat',
        'tanggal_lahir',
        'tanggal_bergabung',
    ];
    public function cuti()
    {
        return $this->hasMany(Cuti::class);
    }

    public function remainingLeave()
    {
        $totalQuota = 12;
        $yearsWorked = now()->year - $this->tanggal_bergabung->year;
        $totalLeaveTaken = $this->cuti->sum('lama_cuti');

        $remainingLeave = $totalQuota - ($yearsWorked * $totalQuota) + $totalLeaveTaken;

        return max($remainingLeave, 0);
    }
}
