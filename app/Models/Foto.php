<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Foto extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $casts=[
        'id'=>'string',
    ];
    protected $fillable=[
        'nama','link','keterangan','status'
    ];
    protected $hidden = ["deleted_at","created_at","updated_at"];

    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }
    public function scopeSlider($query)
    {
        return $query->where('status',1);
    }
    public function scopeBanner($query)
    {
        return $query->where('status',2);
    }
}
