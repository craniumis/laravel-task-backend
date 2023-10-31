<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class Companies extends Model
{
    use HasFactory, Notifiable;

    public function getLogoImageAttribute(){
        $logo = '';
        if ($this->logo){
            if (Storage::exists("company/".$this->logo)){
                $logo = asset("storage/company/".$this->logo);
            }
        }
        return $logo;
    }

    public function Employees():HasMany
    {
        return $this->hasMany(Employees::class);
    }
}
