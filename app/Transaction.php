<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Transaction extends Model
{
    // protected $table = 'products';
    protected $hidden = [
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    use SoftDeletes;

    public static function boot()
    {
       parent::boot();
       static::creating(function($model) { $user = Auth::user(); $model->created_by = $user->id; });
       static::updating(function($model) { $user = Auth::user(); $model->updated_by = $user->id; });
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
    public function people()
    {
        return $this->belongsTo('App\People');
    }
}
