<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';

    protected $fillable = [
        'id',
        'description',
        'pay_id',
        'payment_date',
        'payment_method',
        'payment_status',
        'amount',
        'users_id',
        'created_at'
    ];


    public function user(){
        return $this->belongsTo(User::class,'users_id');
    }
}
