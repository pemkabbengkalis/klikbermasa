<?php
namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\FieldFormLayanan;
use App\Models\ApiLayanan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class LayananController extends Controller
{
    private $view = 'backend.layanan.';
    private $module = 'layanan';
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
        $query = $request->user()?->instansi ? Layanan::with('instansi.kategori')->whereBelongsTo($request->user()->instansi)->withCount('data_pengajuan_layanan') :Layanan::with('instansi.kategori')->withCount('data_pengajuan_layanan') ;
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $button = '<div class="btn-group">';
                $button .= Route::has('layanan.edit') ? '<a href="' . route('layanan.edit', $row->id) . '" class="btn btn-sm btn-warning bi bi-pencil-square"> </a>' : '';

                $button .= Route::has('layanan.destroy') ? '<a class="btn btn-sm btn-danger bi bi-trash" onclick="if(confirm(\'Hapus data ini \')){ deldata(\''.$row->id.'\');} "></a>' : '';
                $button .= '</div>';
                return $button;
            })
            ->addColumn('icon', function ($q) {
                $icon = $q->icon && media_exists($q->icon) ? $q->icon : '/noimage.webp';
                return '<img src="'.$icon.'" height="60">';
            })
            ->addColumn('nama', function ($q) {
                return $q->nama . '<br><small class="text-muted"><b>' . $q->instansi->nama .'</b><br><i>'.str($q->deskripsi)->limit(150,'...'). '</i></small>';
            })
            ->addColumn('status', function ($q) {
                return $q->status_layanan == 'pending' ? '<span class="badge bg-warning">TUNDA</span>' : '<span class="badge bg-success">PUBLIK</span>';
            })
            ->rawColumns(['aksi','icon','nama','status','kategori'])
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
    public function store(Request $request,Layanan $layanan) {
        $data = $request->validate([
            'nama' => 'required|string',
            'status_layanan' => $request->user()->isAdmin() ? 'required|string' : 'nullable',
            'deskripsi' => 'required|string',
            'jenis' => 'required|string',
            'link' => 'nullable',
            'file' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'instansi_id' => 'nullable|string',
        ]);
        $data['slug'] = str($request->nama)->slug();
        if($request->user()->isAdmin()){
            $result = $layanan->create($data);
        }else{
            $result = $request->user()->instansi->layanan()->create($data);
        }
        if($result){

        if ($request->hasFile('file')) {
            $fname = $result->addFile([
                'file'=>$request->file('file'),
                'mime_type'=>['image/png','image/jpeg'],
                'purpose'=>'icon-'.$result->id
            ]);
            $result->update(['icon'=>$fname]);
        }
        return to_route('layanan.edit',$result->id)->with('success', 'Berhasil Ditambahkan');

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Layanan $layanan) {
        return view($this->view . 'show', ['data' => $layanan]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Layanan $layanan) {
        $data = [
            'data' => $layanan,
            'field' => request('field_id') ? FieldFormLayanan::findOrFail(request('field_id')) : null,
            'api' => request('api_id') ? ApiLayanan::findOrFail(request('api_id')) : null,
        ];

        if ($fieldid = request('delete_field_id')) {
            $data = FieldFormLayanan::findOrFail($fieldid)?->delete();
            return to_route('layanan.edit',$layanan->id)->with('success', 'Berhasil Dihapus');
        }
        if ($fieldid = request('delete_api_id')) {
            $data = ApiLayanan::findOrFail($fieldid)?->delete();
            return to_route('layanan.edit',$layanan->id)->with('success', 'Berhasil Dihapus');
        }
        return view($this->view . 'form', $data);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Layanan $layanan) {
        if($request->updatelayanan){
            $valid = $request->validate([
                'nama' => 'required|string',
                'status_layanan' => $request->user()->isAdmin() ? 'required|string' : 'nullable',
                'deskripsi' => 'required|string',
                'jenis' => 'required|string',
                'link' => $layanan->jenis == 'APLIKASI' ? 'nullable|url' : 'nullable',
                'display_to_home' => 'nullable|numeric',
                'file' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
        $valid['slug'] = str($request->nama)->slug();

            if ($layanan->update($valid)) {

                if ($request->hasFile('file')) {
                    $fname = $layanan->addFile([
                        'file'=>$request->file('file'),
                        'mime_type'=>['image/png','image/jpeg'],
                        'purpose'=>'icon-'.$layanan->id
                    ]);
                    $layanan->update(['icon'=>$fname]);
                }
            }
        }

        if($request->createfield){
            $form = $request->validate([
                'judul_kolom' => 'required|string',
                'nama_kolom' => 'required|string',
                'jenis_input' => 'required|string',
                'keterangan_form' => 'required|string',
                'wajib' => 'required|string',
                'status' => 'required|string',
                'urutan' => 'required|numeric',
                'petunjuk' => 'required|string',

            ]);
            $form['keterangan'] = $request->keterangan_form;
            $layanan->formulir()->create( $form);
            return to_route('layanan.edit',$layanan->id)->with('success', 'Berhasil Disimpan');

        }
        if($request->createapi){
            $form = $request->validate([
                'type' => 'required|string',
                'method' => 'required|string',
                'url' => 'required|string',
                'keterangan' => 'required|string',
            ]);
            $layanan->api()->create( $form);
            return to_route('layanan.edit',$layanan->id)->with('success', 'Berhasil Disimpan');

        }
        if($apiid = $request->updateapi){
            $form = $request->validate([
                'type' => 'required|string',
                'method' => 'required|string',
                'url' => 'required|string',
                'keterangan' => 'required|string',
            ]);
            ApiLayanan::findOrFail($apiid)?->update( $form);
            return to_route('layanan.edit',$layanan->id)->with('success', 'Berhasil Disimpan');

        }
        if($fieldid = $request->updatefield){
            $form = $request->validate([
                'judul_kolom' => 'required|string',
                'nama_kolom' => 'required|string',
                'jenis_input' => 'required|string',
                'keterangan_form' => 'required|string',
                'wajib' => 'required|string',
                'status' => 'required|string',
                'urutan' => 'required|numeric',
                'petunjuk' => 'required|string',

            ]);
            $form['keterangan'] = $request->keterangan_form;

            FieldFormLayanan::findOrFail($fieldid)?->update( $form);
            return to_route('layanan.edit',$layanan->id)->with('success', 'Berhasil Disimpan');

        }

        return back()->with('success', 'Berhasil Disimpan');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Layanan $layanan) {
        if (!request()->isMethod('delete')){
            return back();
        }
        $layanan->delete();

    }
}
