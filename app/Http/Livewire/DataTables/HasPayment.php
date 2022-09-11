<?php

namespace App\Http\Livewire\DataTables;

trait HasPayment
{
    public function getStatusBadgeAttribute()
    {
    	$badges = [
    		'1' => 'bg-yellow-100 text-yellow-800',
    		'2' => 'bg-green-100 text-green-800',
            '3' => 'bg-gray-100 text-gray-800',
            '4' => 'bg-red-100 text-red-800',
    	];

    	return $badges[$this->status];
    }

    public function getStatusNameAttribute()
    {
        $names = [
        '1' => 'belum diperiksa',
        '2' => 'sudah dibayar',
        '3' => 'siap dibayar',
        '4' => 'perbaiki',
        ];

        return $names[$this->status];
    }

}
