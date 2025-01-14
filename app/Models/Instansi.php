<?php

namespace App\Models;

use App\Traits\Fileable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
class Instansi extends Model
{
    use HasFactory,HasUuids,SoftDeletes,Fileable;

    protected $fillable = ['nama', 'singkatan', 'alamat','icon'];

    public function layanan(){
        return $this->hasMany(Layanan::class);
    }
    public function data_pengajuan_layanan(){
        return $this->hasMany(DataPengajuanLayanan::class);
    }
    public function user(){
        return $this->hasOne(User::class);
    }
    public function kategori(){
        return $this->hasOne(Kategori::class);
    }

}
