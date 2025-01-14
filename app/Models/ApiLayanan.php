<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
class ApiLayanan extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $fillable = ['method', 'url', 'keterangan', 'hits','type'];
    public function  layanan(){
        return $this->belongsTo(Layanan::class);
    }
}
