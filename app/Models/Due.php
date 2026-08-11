<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Due extends Model
{
    protected $fillable = [
        'user_id',
        'month_year',
        'amount',
        'status',
        'payment_date',
    ];

    protected function casts(): array
    {
        return [
            'payment_date' => 'date',
        ];
    }

    /**
     * Get the user that owns the due.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get formatted month year label.
     */
    public function getMonthLabelAttribute(): string
    {
        $months = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember',
        ];

        $parts = explode('-', $this->month_year);
        $monthName = $months[$parts[1]] ?? $parts[1];

        return $monthName . ' ' . $parts[0];
    }
}
