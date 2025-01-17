<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Fileable;

class Layanan extends Model
{
    use HasFactory,HasUuids,SoftDeletes,Fileable;
    protected $fillable = ['instansi_id', 'kategori_id', 'nama', 'deskripsi', 'jenis', 'jam_operasional', 'link', 'hits','display_to_home','status_layanan','published_at','icon'];
    public function formulir(){
        return $this->hasMany(FieldFormLayanan::class)->orderBy('urutan');
    }

    public function formulir_active(){
        return $this->hasMany(FieldFormLayanan::class)->whereStatus('Aktif')->orderBy('urutan');
    }
    public function api(){
        return $this->hasMany(ApiLayanan::class);
    }
    public function scopePublished($query){
        return $query->where('status_layanan', 'published');
    }
    public function instansi(){
        return $this->belongsTo(Instansi::class);
    }

    public function kategori(){
        return $this->belongsTo(Kategori::class);
    }
    public function tiket(){
        return $this->hasOne(Tiket::class);
    }
    public function data_pengajuan_layanan(){
        return $this->hasMany(DataPengajuanLayanan::class);
    }
}
