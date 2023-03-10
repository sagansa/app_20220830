<?php

namespace App\Http\Livewire\DataTables;

trait HasSalesDirect
{

    public function getPaymentStatusBadgeAttribute()
    {
    	$badges = [
    		'1' => 'bg-yellow-100 text-yellow-800',
    		'2' => 'bg-green-100 text-green-800',
            '3' => 'bg-red-100 text-red-800',

    	];

    	return $badges[$this->payment_status];
    }

    public function getPaymentStatusNameAttribute()
    {
        $names = [
            '1' => 'proses validasi',
            '2' => 'valid',
            '3' => 'tidak valid',
        ];

        return $names[$this->payment_status];
    }

    public function getDeliveryStatusBadgeAttribute()
    {
    	$badges = [
    		'1' => 'bg-yellow-100 text-yellow-800',
    		'2' => 'bg-yellow-100 text-green-800',
            '3' => 'bg-green-100 text-green-800',
            '4' => 'bg-green-100 text-green-800',
            '5' => 'bg-green-100 text-green-800',
            '6' => 'bg-gray-100 text-gray-800',
    	];

    	return $badges[$this->delivery_status];
    }

    public function getDeliveryStatusNameAttribute()
    {
        $names = [
            '1' => 'belum diproses',
            '2' => 'pesanan diproses',
            '3' => 'siap dikirim',
            '4' => 'telah dikirim',
            '5' => 'selesai',
            '6' => 'dikembalikan',
        ];

        return $names[$this->delivery_status];
    }


}
