<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class InstansiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $view = 'backend.instansi.';
    private $module = 'instansi';
    public function index(Request $request)
    {
        if($request->ajax()){
            return $this->data($request);
        }
        return view($this->view.'index');
    }

    public function data($request)
    {
        $query = Instansi::with('kategori','layanan');
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('logo', function ($q) {
                $icon = $q->icon && media_exists($q->icon) ? $q->icon : '/noimage.webp';
                return '<img src="'.$icon.'" height="60">';
            })
            ->addColumn('aksi', function ($row) {
                $button = '<div class="btn-group">';
                $button .= '<a href="' . route('instansi.edit', $row->id) . '" class="btn btn-sm btn-warning bi bi-pencil-square"> </a>';
                $button .= Route::has('instansi.destroy') && !$row->kategori()->exists() && !$row->layanan()->exists() ? '<a class="btn btn-sm btn-danger bi bi-trash" onclick="if(confirm(\'Hapus data ini \')){ deldata(\''.$row->id.'\');} "></a>' : '';
                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['aksi','logo'])
            ->toJson();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data = [
            'data' => null,
            ];
        return view($this->view.'form',$data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'singkatan' => 'required|string',
            'alamat' => 'required|string',
            'file' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
        if($data = Instansi::create($data)){
            if ($request->hasFile('file')) {
                $fname = $data->addFile([
                    'file'=>$request->file('file'),
                    'mime_type'=>['image/png','image/jpeg'],
                    'purpose'=>'icon-'.$data->id
                ]);
                $data->update(['icon'=>$fname]);
            }
            return to_route('instansi.index')->with('success', 'Berhasil Disimpan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Instansi $Instansi)
    {
        return $Instansi;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Instansi $Instansi)
    {
        $data = [
            'data' =>  $Instansi,
            ];
        return view($this->view.'form',$data);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Instansi $instansi)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'singkatan' => 'required|string',
            'alamat' => 'required|string',
        ]);
        if($data = $instansi->update($data)){
            if ($request->hasFile('file')) {
                $fname = $instansi->addFile([
                    'file'=>$request->file('file'),
                    'mime_type'=>['image/png','image/jpeg'],
                    'purpose'=>'icon-'.$instansi->id
                ]);
                $instansi->update(['icon'=>$fname]);
            }
        }
        return to_route('instansi.index')->with('success', 'Berhasil Disimpan');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instansi $instansi)
    {
        if (!request()->isMethod('delete')){
            return back();
        }
            $instansi->delete();
    }
}
