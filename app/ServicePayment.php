<?php

namespace App;

use App\Models\Discount;
use Illuminate\Database\Eloquent\Model;

class ServicePayment extends Model
{
    protected $fillable = [
        'totalsrd',
        'totalusd',
        'totaleur',
        'client_id'];


    public function servicePayments()
    {
        return $this->hasMany(ServiceOrder::class);
    }

    public function orderPayments()
    {
        return $this->hasMany(ProductOrder::class);
    }

    public function orderDiscounts()
    {
        return $this->hasMany(Discount::class);
    }

    public function orderServiceDiscounts()
    {
        return $this->hasMany(Discount::class)->where('discounts.type', '=', 'service');
    }

    public function orderProductDiscounts()
    {
        return $this->hasMany(Discount::class)->where('discounts.type', '=', 'product');
    }

    public function delete()
    {
        // delete all related photos
        $this->servicePayments()->delete();
        $this->orderPayments()->delete();
        $this->orderDiscounts()->delete();
        // as suggested by Dirk in comment,
        // it's an uglier alternative, but faster
        // Photo::where("user_id", $this->id)->delete()

        // delete the user
        return parent::delete();
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
