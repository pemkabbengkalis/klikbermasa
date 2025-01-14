<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use View;
class FieldFormLayanan extends Model
{

    use HasFactory,HasUuids,SoftDeletes;
    protected $fillable = [
'judul_kolom','nama_kolom','jenis_input','keterangan','wajib','status','petunjuk','urutan','layanan_id'
    ];
    public function layanan(){
        $this->belongsTo(Layanan::class);
    }
    public function getTextAttribute(){
        return View::make('form.text', $this)->render();
    }
    // public function getTextAttribute(){
    //     return View::make('form.text',$this);
    // }

    public function getNoWaAttribute(){
        return View::make('form.no_wa',$this)->render();
    }
    public function getNikAttribute(){
        return View::make('form.nip',$this)->render();
    }
    public function getTextareaAttribute(){
        return View::make('form.textarea',$this)->render();
    }
    public function getPilihanAttribute(){
        return View::make('form.pilihan',$this)->render();
    }
    public function getFilePdfAttribute(){
        return View::make('form.file_pdf',$this)->render();
    }
    public function getImageAttribute(){
        return View::make('form.image',$this)->render();
    }
}
