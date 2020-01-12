<?php

namespace App\Models;

class ShareX
{

    protected $table = 'shareX';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'last_used', 'last_ip'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }


}
