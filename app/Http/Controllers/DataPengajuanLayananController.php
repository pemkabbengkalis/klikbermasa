<?php
namespace App\Http\Controllers;

use App\Models\DataPengajuanLayanan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Route;
class DataPengajuanLayananController extends Controller
{
    private $view = 'backend.pengajuan.';
    private $module = 'pengajuan';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $query = DataPengajuanLayanan::with('layanan','user')->first();
        // return $query->file;
        return view($this->view . 'index');
    }

    public function data(Request $request) {
        $query = DataPengajuanLayanan::with('layanan','user','tiket');
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $button = '<div class="btn-group">';
                $button .= Route::has('pengajuan' . '.show') ? '<a href="' . route('pengajuan' . '.show', $row->id) . '" class="btn btn-sm btn-info bi bi-eye"> </a>' : '';
                $button .= Route::has('pengajuan' . '.edit') ? '<a href="' . route('pengajuan' . '.edit', $row->id) . '" class="btn btn-sm btn-warning bi bi-pencil-square"> </a>' : '';
                $button .= Route::has('pengajuan' . '.destroy') ? '<a class="btn btn-sm btn-danger bi bi-trash" onclick="sw_delete(\'' . $row->id . '\')"></a>' : '';
                $button .= '</div>';
                return $button;
            })
            ->addColumn('created_at', function ($row) {
                return '<small class="text-muted">'.$row->created_at->diffForHumans().'</small>';
            })
            ->addColumn('pemohon', function ($row) {
                return $row->user->name;
            })
            ->addColumn('nik', function ($row) {
                return $row->user->nik;
            })
            ->rawColumns(['aksi','created_at'])
            ->toJson();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $data = [
            'data' => null
        ];
        return view($this->view . 'form', $data);

    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show(DataPengajuanLayanan $dataPengajuanLayanan) {
        return view($this->view . 'show', ['data' => $dataPengajuanLayanan]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataPengajuanLayanan $dataPengajuanLayanan) {
        $data = [
            'data' => $dataPengajuanLayanan
        ];
        return view($this->view . 'form', $data);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataPengajuanLayanan $dataPengajuanLayanan) {
        $data = $request->validate([
            'nama_agen' => 'required|string',
            'nik_agen' => 'required|numeric|gt:16|unique:agens,nik_agen,'.$dataPengajuanLayanan->id,
            'nama_pemilik' => 'required|string',
            'email' => 'required|email',
            'no_rekening' => 'required|string',
            'alamat_agen' => 'required|string',
            'status_agen' => 'required|string',
            'telp' => 'required|string',
            'desa_id' => 'required|string',
            'password' => 'string|confirmed|min:8|nullable',
            'password_confirmation' => 'string|nullable'
        ]);
        $dataPengajuanLayanan->update($data);
        $dataPengajuanLayanan->user()->update([
            'username' => $request->nik_agen
        ]);
        if ($password = $request->password) {
            $dataPengajuanLayanan->user()->update([
                'password' => bcrypt($password)
            ]);
        }

        return back()->with('success', 'Berhasil Disimpan');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataPengajuanLayanan $dataPengajuanLayanan) {
        if (!request()->isMethod('delete'))
            return back();
        $dataPengajuanLayanan->delete();
        return to_route($this->module)->with('success', 'Berhasil dihapus');
    }
}
