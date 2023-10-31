<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employees extends Model
{
    use HasFactory;

    public function getFullNameAttribute(){
        return $this->first_name." ".$this->last_name;
    }

    public function Company():BelongsTo
    {
        return $this->belongsTo(Companies::class);
    }
}
