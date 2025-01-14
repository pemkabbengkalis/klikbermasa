<?php
namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    private $view = 'backend.kategori.';
    private $module = 'kategori';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {

        if($request->ajax()){
            return $this->data($request);
        }
        return view($this->view . 'index');
    }

    public function data($request) {
        $query = Kategori::query();
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $button = '<div class="btn-group">';
                $button .= Route::has( 'kategori.show') ? '<a href="' . route('kategori.show', $row->id) . '" class="btn btn-sm btn-info bi bi-eye"> </a>' : '';
                $button .= Route::has('kategori.edit') ? '<a href="' . route( 'kategori.edit', $row->id) . '" class="btn btn-sm btn-warning bi bi-pencil-square"> </a>' : '';
                $button .= Route::has('kategori.destroy') && $row->layanan_count==0 ? '<a class="btn btn-sm btn-danger bi bi-trash" onclick="sw_delete(\'' . $row->id . '\')"></a>' : '';
                $button .= '</div>';
                return $button;
            })
            ->addColumn('icon', function ($q) {
                $icon = $q->icon && media_exists($q->icon) ? $q->icon : '/noimage.webp';
                return '<img src="'.$icon.'" height="60">';
            })
            ->rawColumns(['aksi', 'icon'])
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
    public function store(Request $request,Kategori $kategori) {
        $data = $request->validate([
            'instansi_id' => 'required|string',
            'nama' => 'required|string',
            'sort' => 'required|numeric',
            'file' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',

        ]);
        if($data = $kategori->create($data)){
            if ($request->hasFile('file')) {
                $fname = $data->addFile([
                    'file'=>$request->file('file'),
                    'mime_type'=>['image/png','image/jpeg'],
                    'purpose'=>'icon-'.$data->id
                ]);
                $data->update(['icon'=>$fname]);
            }
            return to_route('kategori.edit',$data->id)->with('success', 'Berhasil Disimpan');

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori) {
        return view($this->view . 'show', ['data' => $kategori]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori) {
        $data = [
            'data' => $kategori
        ];
        return view($this->view . 'form', $data);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori) {
        $data = $request->validate([
            'instansi_id' => $kategori->instansi ? 'nullable' : 'required|string',
            'nama' => 'required|string',
            'sort' => 'required|numeric',
            'file' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',

        ]);

        if ($data = $kategori->update($data)) {
            if ($request->hasFile('file')) {
                $fname = $kategori->addFile([
                    'file'=>$request->file('file'),
                    'mime_type'=>['image/png','image/jpeg'],
                    'purpose'=>'icon-'.$kategori->id
                ]);
                $kategori->update(['icon'=>$fname]);
            }
        return back()->with('success', 'Berhasil Disimpan');

        }



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori) {
        if (!request()->isMethod('delete'))
            return back();
        $kategori->delete();
        return to_route($this->module)->with('success', 'Berhasil dihapus');
    }
}
