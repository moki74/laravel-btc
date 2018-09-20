<?php

namespace moki74\LaravelBtc\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
   public function order()
   {
       return $this->belongsTo(config('bitcoind.order-model'));
   }

   public function user()
   {
       return $this->belongsTo(config('bitcoind.user-model'));
   }

   public function scopeUnpaid($query)
   {
       return $query->where('txid', '=','');
   }

   public function scopeNot_confirmed($query)
   {
       return $query->where('txid','!=','')
                    ->where('paid','=', 0);

   }

   public function scopePaid($query)
   {
       return $query->where('paid','=', 1);
   }
}
