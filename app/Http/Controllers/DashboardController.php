<?php
namespace App\Http\Controllers;
use App\Models\Layanan;
use App\Models\Instansi;
use App\Models\DataPengajuanLayanan;

class DashboardController extends Controller
{



    public function getDashboardData()
    {
        $user = request()->user();
        return [
            'jumlah_layanan'=>$user->isAdmin() ? Layanan::count() : $user->instansi->layanan->count(),
            'jumlah_instansi'=>$user->isAdmin() ? Instansi::count() : 0,
            'jumlah_permohonan'=>$user->isAdmin() ? DataPengajuanLayanan::count() : $user->instansi->data_pengajuan_layanan->count(),
        ];
    }
    function index(){
        if(request()->user()->isAdmin()){
            return view('backend.dashboard.index',$this->getDashboardData());
        }
        return view('backend.dashboard.instansi',$this->getDashboardData());
    }
}
