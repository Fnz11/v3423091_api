<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaction extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELLED = 'cancelled';
    const PAYMENT_DUE_HOURS = 24;  // Add this line

    protected $fillable = [
        'user_id',
        'total_amount',
        'payment_method',
        'payment_token',
        'shipping_address',
        'payment_due',
        'status'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'shipping_address' => 'array',
        'payment_due' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($transaction) {
            $transaction->payment_due = Carbon::now()->addHours(self::PAYMENT_DUE_HOURS);
            $transaction->status = self::STATUS_PENDING;
        });

        // Add event listener for status changes
        static::updating(function ($transaction) {
            $original = $transaction->getOriginal('status');
            $new = $transaction->status;

            if ($original !== $new) {
                if ($new === self::STATUS_CANCELLED || $new === self::STATUS_FAILED) {
                    $transaction->restoreStock();
                }
            }
        });
    }

    public static function generatePaymentToken()
    {
        $prefix = 'VA';
        $timestamp = now()->format('ymd');
        $random = strtoupper(substr(uniqid(), -6));
        return $prefix . $timestamp . $random;
    }

    public function isExpired()
    {
        return $this->payment_due->isPast();
    }

    public function canBeCancelled()
    {
        return $this->status === self::STATUS_PENDING && !$this->isExpired();
    }

    public function cancel()
    {
        if ($this->canBeCancelled()) {
            $this->update(['status' => self::STATUS_CANCELLED]);
            return true;
        }
        return false;
    }

    public function reduceStock()
    {
        foreach ($this->items as $item) {
            $clothes = $item->clothes;
            $clothes->stock -= $item->quantity;
            $clothes->save();
        }
    }

    public function restoreStock()
    {
        foreach ($this->items as $item) {
            $clothes = $item->clothes;
            $clothes->stock += $item->quantity;
            $clothes->save();
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}