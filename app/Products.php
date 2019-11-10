<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    protected $table = 'products';

    use SoftDeletes;

    protected $fillable = [
        'issn',
        'name',
        'status',
        'customer'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $dates = ['deleted_at'];

    public function customer()
    {
        return $this->belongsTo('App\Customers', 'customer');
    }
}
