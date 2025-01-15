<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\Sanctum;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasUuids,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nik',
        'name',
        'email',
        'username',
        'password',
        'level',
        'instansi_id',
        'user_data',
        'last_login_ip',
        'last_login_time',
        'email_verified_at',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password','remember_token','email_verified_at','deleted_at',"created_at","updated_at"];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'id' => 'string',
        'user_data' => 'array',
    ];
    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }
    public function instansi(){
        return $this->belongsTo(Instansi::class);
    }
    public function isSuperAdmin(){
        return $this->level=='superadmin';
    }
    public function isAdmin(){
        return $this->level=='admin';
    }
    public function isInstansi(){
        return $this->level=='instansi';
    }

    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = $value ? bcrypt($value) : $this->password;
    }

    public function tokens(): object
    {
        return $this->morphMany(Sanctum::$personalAccessTokenModel, 'tokenable');
    }

    public function getNoHpAttribute()
    {
        return $this->user_data['no_hp'] ?? null;
    }

    public function getJenisKelaminAttribute()
    {
        return $this->user_data['jenis_kelamin'] ?? null;
    }

    public function getTempatLahirAttribute()
    {
        return $this->user_data['tempat_lahir'] ?? null;
    }

    public function getTanggalLahirAttribute()
    {
        return $this->user_data['tanggal_lahir'] ?? null;
    }
    public function getAlamatAttribute()
    {
        return $this->user_data['alamat'] ?? null;
    }
    public function getKelurahanAttribute()
    {
        return $this->user_data['kelurahan'] ?? null;
    }
    public function getKecamatanAttribute()
    {
        return $this->user_data['kecamatan'] ?? null;
    }


    public static function boot()
    {
        parent::boot();
        static::deleted(function ($user) {
            $user->tokens()->delete();
        });
    }
}
