<?php

namespace App\Models;

use Carbon\Carbon;
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
        $totalAnnualQuota = 12; // Total annual leave quota per year
        $yearsWorked = now()->year - Carbon::parse($this->tanggal_bergabung)->year;

        // Total leave quota based on the number of years worked
        $totalLeaveEntitlement = $yearsWorked * $totalAnnualQuota;

        // Total leave taken by the employee
        $totalLeaveTaken = $this->cuti->sum('lama_cuti');

        // Calculate remaining leave
        $remainingLeave = $totalLeaveEntitlement - $totalLeaveTaken;

        // Ensure remaining leave is not negative
        return max($remainingLeave, 0);
    }
}
