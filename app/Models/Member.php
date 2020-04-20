<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email'
    ];

    // public function discountList (){
    //     return $this->hasMany('App\Models\DiscountProgram', 'membership_id', 'id');
    // }
}
