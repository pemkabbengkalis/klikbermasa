<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Kategori;
use App\Models\ApiLayanan;
use Illuminate\Http\Request;

class ApiLayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->detail_layanan){
            return $this->detail_layanan($request);
        }
        elseif($request->detail_informasi){
            return $this->detail_informasi($request);

        }
        else{
            return $this->list_layanan($request);
        }
    }
    function list_layanan($request){

        $data = Kategori::with('instansi.layanan')->orderBy('sort')->get();
        $list['code'] = 200;
        $list['status'] = "success";
        $list['data']['list_layanan'] = array();
        foreach($data as $row){

            $i['path'] = $row->slug;
            $i['icon'] = 'https://'.api_url($row->icon);
            $i['nama'] = $row->nama;
            $i['jenis'] = 'LAYANAN_INSTANSI';
            $i['sort'] = $row->sort;
            array_push($list['data']['list_layanan'], $i);

            foreach($row->instansi->layanan->where('display_to_home',1)->where('status_layanan','published') as $r){
                if($r->jenis=='INFORMASI'){
                    $a['path'] = $r->slug;
                    $a['icon'] = 'https://'.api_url($r->icon);
                    $a['nama'] = $r->nama;
                    $a['jenis'] = $r->jenis;
                    $a['sort'] = 100;
                array_push($list['data']['list_layanan'], $a);
                }elseif($r->jenis=='APLIKASI'){
                    $app['link'] = $r->link;
                    $app['icon'] = 'https://'.api_url($r->icon);
                    $app['nama'] = $r->nama;
                    $app['jenis'] = $r->jenis;
                    $app['sort'] = 100;
                array_push($list['data']['list_layanan'], $app);
            }elseif($r->jenis=='API'){
                $api['path'] = $r->slug;
                $api['icon'] = 'https://'.api_url($r->icon);
                $api['nama'] = $r->nama;
                $api['jenis'] = $r->jenis;
                $api['sort'] = 100;
                array_push($list['data']['list_layanan'], $api);
            }

        }
        }
        $list['data']['list_layanan'] = collect($list['data']['list_layanan'])->sortBy('sort');
        return response()->json($list);

    }
    function detail($id=null) {
        if(!$id){
            $data['code'] = 404;
            $data['status'] = "Not Found";
            return response()->json($data);
        }

        $query = Kategori::with('instansi.layanan')->orderBy('sort')->whereSlug($id)->first();
        $query2 = Layanan::whereSlug($id)->first();
        if($query){
            $data['code'] = 200;
            $data['status'] = "success";
            $data['data']['instansi'] = $query->instansi->nama;
            $data['data']['list_layanan'] = array();
            foreach ($query->instansi->layanan->where('status_layanan','published') as $r) {
                if($r->jenis=='INFORMASI'){
                    $a['path'] = $r->slug;
                    $a['icon'] = 'https://'.api_url($r->icon);
                    $a['nama'] = $r->nama;
                    $a['jenis'] = $r->jenis;
                    $a['sort'] = 100;
                array_push($data['data']['list_layanan'], $a);
                }elseif($r->jenis=='APLIKASI'){
                    $app['link'] = $r->link;
                    $app['icon'] = 'https://'.api_url($r->icon);
                    $app['nama'] = $r->nama;
                    $app['jenis'] = $r->jenis;
                    $app['sort'] = 100;
                array_push($data['data']['list_layanan'], $app);
            }elseif($r->jenis=='API'){
                $api['path'] = $r->slug;
                $api['icon'] = 'https://'.api_url($r->icon);
                $api['nama'] = $r->nama;
                $api['jenis'] = $r->jenis;
                $api['sort'] = 100;
                array_push($data['data']['list_layanan'], $api);
            }

            }
        }elseif($query2){

                $data['code'] = 200;
                $data['status'] = "success";
                $data['data'] = [
                    'icon'=>'https://'.api_url($query2->icon),
                    'nama'=> $query2->nama,
                    'jenis'=> $query2->jenis,
                    'keterangan'=> $query2->deskripsi,

                    ];
                    if(in_array($query2->jenis,['API','APLIKASI'])){
                        $data['data']['link'] = $query2->link;
                    }
        }else{
            $data['code'] = 404;
            $data['status'] = "Not Found";
        }
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ApiLayanan $apiLayanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ApiLayanan $apiLayanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ApiLayanan $apiLayanan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApiLayanan $apiLayanan)
    {
        //
    }
}
