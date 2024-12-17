<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;


class Payment extends Model
{
    use HasFactory;
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
        'payment_status',
        'amount',
        'users_id',
        'created_at'
    ];


    public function user(){
        return $this->belongsTo(User::class,'users_id');
    }
    public static function search_pay($search)
    {
        $payment = self::where('pay_id', 'LIKE', '%' . $search . '%')
            ->orWhere('description', 'LIKE', '%' . $search . '%')
            ->orWhere('payment_method', 'LIKE', '%' . $search . '%')
            ->paginate(20);
        return $payment;
    }
}
