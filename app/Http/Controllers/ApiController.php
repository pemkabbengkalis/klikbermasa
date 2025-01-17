<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\User;
use App\Models\Layanan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|regex:/^[a-zA-Z\s]*$/|max:255',
            'nik' => 'required|numeric|digits:16|unique:users,nik,NULL,id,deleted_at,NULL',
            'password' => 'required|string|min:6',
            'validate_password' => 'required|string|same:password|min:6',
        ]);
        $validator->getTranslator()->setLocale('id');
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $request->merge([
            'password' => $request->password,
            'level' => 'user',
            'status' => 'active',
        ]);

        if ($user = User::create($request->all())) {
            return response()->json(['status' => true, 'message' => 'Data berhasil disimpan']);
        }

        return response()->json(['status' => false, 'message' => 'Data gagal disimpan'], 500);
    }
    public function store_profil(Request $request) {
        $validator = Validator::make($request->all(), [
            'no_kk' => 'required|numeric|digits:16',
            'no_hp' => 'required|numeric|digits_between:10,13',
            'jenis_kelamin' => 'required|in:L,P',
            'gambar_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $validator->getTranslator()->setLocale('id');
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $request->merge([
            'user_data' => $request->only('no_kk','no_hp','jenis_kelamin')
        ]);
        $user = User::find(auth()->user()->id);
        if ($user->update($request->all())) {
            // /media/lsdkjfjhsdfsdf.jpg
           $fname =  $user->addFile([
                'purpose'                  => 'gambar_ktp',
                'file'                      => $request->file('gambar_ktp'),
                'mime_type'=>['image/jpeg','image/png'],
            ]);
            $user->update([
                'user_data' => array_merge(
                    $user->user_data ?? [], 
                    $request->get('user_data'),
                    ['gambar_ktp' => $fname]
                )
            ]);
            return response()->json(['status' => true, 'message' => 'Data berhasil disimpan']);
        }

        return response()->json(['status' => false, 'message' => 'Data gagal disimpan'], 500);
    }
    public function login(Request $request)
    {
        $credentials=$request->only('nik', 'password');
        $cekuser = User::where(['nik'=>$request->nik])->first();
        if(!$cekuser){
            return response()->json(['status'=>false,'pesan'=>'nik tidak terdaftar']);
        }
        elseif(!Hash::check($request->password, $cekuser->password)){
            return response()->json(['status'=>false,'pesan'=>'Password salah']);
        }

        if (auth()->attempt($credentials)) {
            $token= $cekuser->createToken(uniqid().now())->plainTextToken;
            $response=[
                'status'=>true,
                'message'=>'Login berhasil',
                'data'=>[
                    'user'=>$cekuser,
                    'token'=>$token,
                ],
            ];
        }
        return response()->json($response ?? ['status'=>false, 'message'=>'Login failed']);
    }

    function formulir_layanan(Request $request) {
        $data = Layanan::with('formulir_active','api')->find($request->id_layanan);
        if ($data) {

            $result['code'] = 200;
            $result['status'] = "success";
            $result['data']['endpoint'] = [
                'url' => $data->api->where('type', 'store')->first()?->url,
                'method' => $data->api->where('type', 'store')->first()?->method,
                'description' => $data->api->where('type', 'store')->first()?->keterangan,
            ];
            $result['data']['form'] = [
                'id' => $data->id,
                'name' => 'Permohonan Layanan ' . $data->nama,
            ];
            $result['data']['field'] = array();
            foreach ($data->formulir_active as $row) {
                $i = $row->jenis_input;
                array_push($result['data']['field'], $row->$i);

            }
        }else{
            $result['code'] = 404;
            $result['status'] = "Not Found";
        }

        return $result;
    }
    function detail_layanan(Request $request) {
        $query = Kategori::with('instansi.layanan.file','file')->orderBy('sort')->find($request->id_layanan);
        if(empty($query)){
        $data['code'] = 404;
        $data['status'] = "Not Found";
        } else {

            $data['code'] = 200;
            $data['status'] = "success";
            $data['data']['instansi'] = $query->instansi->nama;
            $data['data']['list_layanan'] = array();
            foreach ($query->instansi->layanan->where('status_layanan','published') as $row) {
                $i['id'] = $row->id;
                $i['icon'] = $row->file?->link_stream;
                $i['nama'] = $row->nama;
                $i['keterangan'] = $row->deskripsi;
                $i['jenis'] = $row->jenis;
                $i['api_link'] = in_array($row->jenis, ['API', 'FORM']) ? url('api/layanan/pengajuan/' . $row->id) : $row->link;
                array_push($data['data']['list_layanan'], $i);
            }
        }
        return $data;
    }
    function list_layanan(Request $request){

        $data = Kategori::with('instansi.layanan.file','file')->orderBy('sort')->get();
        $list['code'] = 200;
        $list['status'] = "success";
        $list['data']['list_layanan'] = array();
        foreach($data as $row){

            $i['id'] = $row->id;
            $i['icon'] = $row->file?->link_stream;
            $i['name'] = $row->nama;
            $a['jenis'] = $row->jenis;
            $i['api_link'] = url('api/layanan/detail/'.$row->id);
            $i['target'] = null;
            $i['sort'] = $row->sort;
            array_push($list['data']['list_layanan'], $i);

            foreach($row->instansi->layanan->where('display_to_home',1) as $r){
                $a['id'] = $r->id;
                $a['icon'] = $r->file?->link_stream;
                $a['nama'] = $r->nama;
                $a['jenis'] = $row->jenis;
                $a['api_link'] = $r->link;
                $a['target'] = '_blank';
                $a['sort'] = 100;
                array_push($list['data']['list_layanan'], $a);
            }
        }
        $list['data']['list_layanan'] = collect($list['data']['list_layanan'])->sortBy('sort');
        return response()->json($list);

    }
    public function home() {
        $slider = Foto::slider()->take(10)->get();

        $sliders=[];
        if ($slider != NULL) {
            foreach ($slider as $s) {
                $item['judul'] = $s->nama;
                $item['src'] = $s->file->link_stream;
                array_push($sliders, $item);
            }
        }

        $banner = Foto::banner()->take(10)->get();

        $banners=[];
        if ($banner != NULL) {
            foreach ($banner as $b) {
                $item=[];
                $item['judul'] = $b->nama;
                $item['src'] = $b->file->link_stream;
                array_push($banners, $item);
            }
        }

        $data = Kategori::with('instansi.layanan.file','file')->orderBy('sort')->get();
        $list_layanan = array();
        foreach($data as $row){

            $i['id'] = $row->id;
            $i['icon'] = $row->file?->link_stream;
            $i['name'] = $row->nama;
            $i['jenis'] = $row->jenis;
            $i['api_link'] = url('api/layanan/detail/'.$row->id);
            $i['target'] = null;
            $i['sort'] = $row->sort;
            array_push($list_layanan, $i);

            foreach($row->instansi->layanan->where('display_to_home',1) as $r){
                $a['id'] = $r->id;
                $a['icon'] = $r->file?->link_stream;
                $a['nama'] = $r->nama;
                $a['jenis'] = $row->jenis;
                $a['api_link'] = $r->link;
                $a['target'] = '_blank';
                $a['sort'] = 100;
                array_push($list_layanan, $a);
            }
        }
        $datas = [
            "slider" => $sliders,
            "banner" => $banners,
            'list_layanan' => $list_layanan
        ];

        return response()->json([
            'status' => 'success',
            'data' => $datas
        ],200);
    }
}
