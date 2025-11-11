<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_note',
        'date',
        'customer_id',
        'subtotal',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class, 'note', 'id_note');
    }

    public static function generateNote()
    {
        $prefix =  'SLS';
        do {
            $uniqNote = $prefix . mt_rand(1000, 9999);
        } while (self::where('id_note', $uniqNote)->exists());

        return $uniqNote;
    }
}
