<?php

namespace App\Http\Livewire\DataTables;

trait HasDeliveryStatus
{
    public function getStatusBadgeAttribute()
    {
    	$badges = [
    		'1' => 'bg-yellow-100 text-yellow-800',
    		'2' => 'bg-green-100 text-green-800',
            '3' => 'bg-blue-100 text-blue-800',
            '4' => 'bg-red-100 text-red-800',
            '5' => 'bg-cyan-100 text-cyan-800',
            '6' => 'bg-gray-100 text-gray-800',
    	];

    	return $badges[$this->status];
    }

    public function getStatusNameAttribute()
    {
        $names = [
        '1' => 'belum dikirim',
        '2' => 'valid',
        '3' => 'sudah dikirim',
        '4' => 'perbaiki',
        '5' => 'siap dikirim',
        '6' => 'dikembalikan'
        ];

        return $names[$this->status];
    }
}
