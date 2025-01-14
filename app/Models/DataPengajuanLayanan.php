<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
class DataPengajuanLayanan extends Model
{
    use HasFactory,HasUuids,SoftDeletes;
    protected $fillable = ['user_id', 'instansi_id', 'layanan_id', 'data_pengajuan', 'dibaca', 'status'];
    protected $casts=[
        'id'=>'string', 'data_pengajuan'=>'array',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function file()
    {
        return $this->morphMany(File::class, 'fileable');
    }
    public function tiket(){
        return $this->hasOne(Tiket::class);
    }
    public function layanan(){
        return  $this->belongsTo(Layanan::class);
    }

    public function instansi(){
        return $this->belongsTo(Instansi::class);
    }
    public function getPengajuanAttribute(){
       return $this->data_pengajuan;
    }
}
