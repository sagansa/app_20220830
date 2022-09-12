<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequestPurchase extends Model
{
    use HasValid;
    use HasFactory;
    use Searchable;

    const STATUSES = [
        '1' => 'process',
        '2' => 'done',

    ];

    protected $fillable = ['store_id', 'date', 'user_id', 'status'];

    protected $searchableFields = ['*'];

    protected $table = 'request_purchases';

    protected $casts = [
        'date' => 'date',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detailRequests()
    {
        return $this->hasMany(DetailRequest::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
