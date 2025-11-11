<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'note',
        'stock_code',
        'qty',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'note', 'id_note');
    }

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class, 'stock_code', 'code');
    }

    public function getLineTotalAttribute(): float
    {
        if ($this->stock) {
            return $this->stock->harga * $this->qty;
        }
        return 0;
    }

    public function getFormattedLineTotalAttribute(): string
    {
        return number_format($this->line_total, 2, ',', '.');
    }
}
