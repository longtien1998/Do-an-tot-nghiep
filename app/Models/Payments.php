<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $table = 'payments';
    protected $casts = [
        'payment_date' => 'datetime',
    ];
    protected $fillable = [
        'id',
        'description',
        'pay_id',
        'payment_date',
        'payment_method',
        'amount',
        'users_id',
        'created_at'
    ];
    public function user(){
        return $this->belongsTo(User::class, 'users_id');
    }
}
