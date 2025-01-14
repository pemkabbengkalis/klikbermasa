<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
class Tiket extends Model
{
    use HasFactory,HasUuids,SoftDeletes;
    protected $fillable = ['kode', 'data_pengajuan_layanan_id', 'jenis_tiket','kode_tiket_api'];
    public function data_pengajuan_layanan(){
        return $this->belongsTo(DataPengajuanLayanan::class);
    }
}
