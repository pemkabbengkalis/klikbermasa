<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $view = 'backend.banner.';
    private $module = 'banner';

    public function index()
    {
        return view($this->view.'index');
    }

    public function data(Request $request)
    {
        $query = Foto::with('file')->banner();
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('foto', function ($q) {
                if (!empty($q->file)) {
                    return '<img src="'.$q->file->link_stream.'" alt="" class="img-circle img-fluid" width="50">';
                } else {
                    return '';
                }
            })
            ->addColumn('aksi', function ($row) {
                $button = '<div class="btn-group">';
                $button .= '<a href="' . route($this->module.'.edit', $row->id) . '" class="btn btn-sm btn-warning bi bi-pencil-square"> </a>';
                $button .= '<button class="btn btn-sm btn-danger bi bi-trash" onclick="sw_delete(\'' . $row->id . '\')"></button>';
                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['aksi','foto'])
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
            'file' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
        $data['status']=2;
        if($data = Foto::create($data)){
            if ($request->hasFile('file')) {
                $data->file()->updateOrCreate(['keterangan'=>'banner'],[
                    'keterangan'                  => 'banner',
                    'data'                      =>  [
                        'disk'      => config('filesystems.default'),
                        'target'    => Storage::putFile($this->module.'/banner/'.date('Y').'/'.date('m').'/'.date('d'),$request->file('file')),
                    ]
                ]);
            }
            return to_route($this->module)->with('success', 'Berhasil Disimpan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Foto $Foto)
    {
        return $Foto;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Foto $Foto)
    {
        $data = [
            'data' =>  $Foto,
            ];
        return view($this->view.'form',$data);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Foto $Foto)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'singkatan' => 'required|string',
            'alamat' => 'required|string',
        ]);
        if($data = $Foto->update($data)){
            if ($request->hasFile('file')) {
                $Foto->file()->updateOrCreate(['keterangan'=>'banner'],[
                    'keterangan'                  => 'banner',
                    'data'                      =>  [
                        'disk'      => config('filesystems.default'),
                        'target'    => Storage::putFile($this->module.'/banner/'.date('Y').'/'.date('m').'/'.date('d'),$request->file('file')),
                    ]
                ]);
            }
        }
        return to_route($this->module)->with('success', 'Berhasil Disimpan');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Foto $Foto)
    {
        if (!request()->isMethod('delete'))
            return back();
            $Foto->delete();
        return to_route($this->module)->with('success', 'Berhasil dihapus');
    }
}
