<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckAssistance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'check_assistances';

    protected $guarded = ['id', 'created_at', 'updated'];

    protected $dates = ['fecha'];

    protected $fillable = [
        'fecha',
        'hora',
        'estatus',
        'user_id',
        'user_check_id'
    ];

    //Uno a Muchos
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
