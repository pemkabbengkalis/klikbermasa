<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Instansi;
use App\Models\DataPengajuanLayanan;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getDashboardData()
    {
        $user = request()->user();
        return [
            'jumlah_layanan'=>$user->isAdmin() ? Layanan::count() : $user->instansi->layanan->count(),
            'jumlah_instansi'=>$user->isAdmin() ? Instansi::count() : 0,
            'jumlah_permohonan'=>$user->isAdmin() ? DataPengajuanLayanan::count() : $user->instansi->data_pengajuan_layanan->count(),
        ];
    }
}
