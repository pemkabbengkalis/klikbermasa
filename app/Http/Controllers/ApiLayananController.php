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

            $i['id'] = $row->id;
            $i['icon'] = 'https://'.api_url($row->icon);
            $i['name'] = $row->nama;
            $i['jenis'] = $row->jenis;
            $i['api_link'] = 'https://'.api_url('/api/layanan?detail_layanan='.$row->id);
            $i['target'] = null;
            $i['sort'] = $row->sort;
            array_push($list['data']['list_layanan'], $i);

            foreach($row->instansi->layanan->where('display_to_home',1)->where('status_layanan','published') as $r){
                if($r->jenis=='INFORMASI'){
                    $a['id'] = $r->id;
                    $a['icon'] = 'https://'.api_url($r->icon);
                    $a['nama'] = $r->nama;
                    $a['jenis'] = $r->jenis;
                    $a['api_link'] = 'https://'.api_url('/api/layanan?detail_informasi='.$r->id);;
                    $a['target'] = null;
                    $a['sort'] = 100;
                    array_push($list['data']['list_layanan'], $a);
                }else{

                $a['id'] = $r->id;
                $a['icon'] = 'https://'.api_url($r->icon);
                $a['nama'] = $r->nama;
                $a['jenis'] = $r->jenis;
                $a['api_link'] = $r->link;
                $a['target'] = '_blank';
                $a['sort'] = 100;
                array_push($list['data']['list_layanan'], $a);
            }
        }
        }
        $list['data']['list_layanan'] = collect($list['data']['list_layanan'])->sortBy('sort');
        return response()->json($list);

    }
    function detail_informasi($request){
        $query = Layanan::published()->find($request->detail_informasi);
        if(empty($query)){
            $data['code'] = 404;
            $data['status'] = "Not Found";
            } else {
                $data['code'] = 200;
                $data['status'] = "success";
                $data['data'] = ['icon'=>'https://'.api_url($query->icon),'nama'=> $query->nama,'keterangan'=>$query->deskripsi] ;
            }
            return $data;
    }
    function detail_layanan($request) {
        $query = Kategori::with('instansi.layanan')->orderBy('sort')->find($request->detail_layanan);
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
                $i['icon'] = 'https://'.api_url($row->icon);
                $i['nama'] = $row->nama;
                $i['keterangan'] = $row->deskripsi;
                $i['jenis'] = $row->jenis;
                $i['api_link'] = in_array($row->jenis, ['API', 'FORM']) ? 'https://'.api_url('/api/layanana?detail_layanan=' . $row->id) : $row->link;
                array_push($data['data']['list_layanan'], $i);
            }
        }
        return $data;
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
