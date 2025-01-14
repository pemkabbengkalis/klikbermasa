<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Fileable;
class Kategori extends Model
{
    use HasFactory,HasUuids,SoftDeletes,Fileable;
    protected $fillable = ['nama', 'slug', 'url', 'icon','sort','instansi_id'];
    public function  layanan(){
        return $this->hasMany(Layanan::class);
    }
    public function  instansi(){
        return $this->belongsTo(Instansi::class);
    }




}
