<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LetterRequest extends Model
{
    protected $fillable = [
        'user_id',
        'letter_type',
        'purpose',
        'status',
        'rejection_reason',
    ];

    /**
     * Get the user that owns the letter request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get available letter types.
     */
    public static function letterTypes(): array
    {
        return [
            'Pengantar KTP',
            'Pengantar SKCK',
            'Surat Keterangan Domisili',
            'Surat Keterangan Tidak Mampu',
            'Surat Pengantar Nikah',
            'Surat Keterangan Kelahiran',
            'Surat Keterangan Kematian',
            'Surat Keterangan Usaha',
            'Surat Pengantar Lainnya',
        ];
    }
}
