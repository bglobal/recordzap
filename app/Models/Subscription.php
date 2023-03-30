<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    protected $primaryKey = 'id';
    // public $timestamps = false;
    
    use HasFactory;
    // use SoftDeletes;
    use Filterable;

    public function order()
    {
        return $this->setConnection('mysql_wp')->belongsTo(Order::class,'entry_id','entry_id');
        
    }
}
