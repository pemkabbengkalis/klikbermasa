<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

if (!function_exists('flc_file_manager')) {
    function flc_file_manager()
    {
        if (!auth()->check()) {
            return 'Not Authorized';
        }
        $data = \App\Models\File::with('user')->whereHost(request()->getHost())->latest()->paginate(10);
        return \Illuminate\Support\Facades\View::make('flc::files', ['data' => $data]);
    }
}

if (!function_exists('tanggal_indo')) {
    function tanggal_indo($val,$with0=false)
    {

  $waktu = date('Y-m-d', strtotime($val));
  $hari_array = array(
      'Minggu',
      'Senin',
      'Selasa',
      'Rabu',
      'Kamis',
      'Jumat',
      'Sabtu'
  );
  $hr = date('w', strtotime($waktu));
  $hari = $hari_array[$hr];
  if($with0==true){
  $tanggal = date('d', strtotime($waktu));
  }else{
  $tanggal = date('j', strtotime($waktu));
  }
  $bulan_array = array(
      1 => 'Januari',
      2 => 'Februari',
      3 => 'Maret',
      4 => 'April',
      5 => 'Mei',
      6 => 'Juni',
      7 => 'Juli',
      8 => 'Agustus',
      9 => 'September',
      10 => 'Oktober',
      11 => 'November',
      12 => 'Desember',
  );

  $bl = date('n', strtotime($waktu));
  $bulan = $bulan_array[$bl];
  $tahun = date('Y', strtotime($waktu));
  $jam = date('H:i T', strtotime($val));

  //untuk menampilkan hari, tanggal bulan tahun jam
  //return "$hari, $tanggal $bulan $tahun $jam";

  //untuk menampilkan hari, tanggal bulan tahun
  return $hari.", ".$tanggal." ".$bulan." ".$tahun;
    }
}
function active_treeview($arr){
    if(in_array(request()->segment(2),$arr)){
        $ec =  'is-expanded';
    }
    return $ec ?? '';
  }
  function active_item($val){
      if(request()->is('*/'.$val) || request()->is('*/'.$val.'/*') ||request()->is('*/'.$val.'/*/*'))
      return 'active';
  }
if (!function_exists('media_size')) {
    function media_size($media)
    {
        $media_exists =  \Illuminate\Support\Facades\Cache::get("media_" . basename($media)) ?? null;
        return $media_exists && isset($media_exists->file_path) && \Illuminate\Support\Facades\Storage::exists($media_exists->file_path) ? size_as_kb($media_exists->file_size)  : null;
    }
}
if (!function_exists('size_as_kb')) {
    function size_as_kb($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
if (!function_exists('media_download')) {
    function media_download($media)
    {
        $media_exists =  \Illuminate\Support\Facades\Cache::get("media_" . basename($media)) ?? null;
        return $media_exists && isset($media_exists->file_path) && \Illuminate\Support\Facades\Storage::exists($media_exists->file_path) ? url($media . '?download=' . md5(request()->session()->getId())) : false;
    }
}


if (!function_exists('media_exists')) {
    function media_exists($media)
    {
        $media_exists =  \Illuminate\Support\Facades\Cache::get("media_" . basename($media)) ?? null;
        return $media_exists && isset($media_exists->file_path) && \Illuminate\Support\Facades\Storage::exists($media_exists->file_path) ? true : false;
    }
}
if (!function_exists('allow_mime')) {

    function allow_mime()
    {
        return 'application/x-zip-compressed,application/zip,image/jpeg,image/png,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/octet-stream';
    }
}
if (!function_exists('media_caching')) {
    function media_caching()
    {
        foreach (\App\Models\File::select('file_path', 'file_name', 'file_type', 'file_size', 'file_hits', 'file_auth', 'host')->get() as $row) {
            if (Storage::exists($row->file_path)) {
                Cache::remember("media_{$row->file_name}", 60 * 60 * 24, function () use ($row) {
                    return json_decode(json_encode([
                        'file_path' => $row->file_path,
                        'file_type' => $row->file_type,
                        'file_host' => $row->host,
                        'file_auth' => $row->file_auth,
                        'file_size' => $row->file_size,
                    ]));
                });
            }
        }
        Cache::remember("media", 60 * 60 * 24, function () {
            return true;
        });
    }
}

if (!function_exists('flc_ext')) {
    function flc_ext()
    {
        return ['jpg', 'jpeg', 'gif', 'zip', 'rar', 'doc', 'docx', 'pdf', 'xls', 'xlsx', 'png', 'webp', 'mp4'];
    }
}

if (!function_exists('flc_file_size')) {
    function flc_file_size($fileName)
    {
        $file = \Illuminate\Support\Facades\Cache::get("media_" . basename($fileName))?->file_path;
        if ($file) {
            return size_as_kb(\Illuminate\Support\Facades\Storage::size($file));
        }
    }
}
if (!function_exists('flc_file_to_path')) {
    function flc_file_to_path($fileName)
    {
        $file = \Illuminate\Support\Facades\Cache::get("media_" . basename($fileName))?->file_path;
        if ($file) {
            return Storage::path($file);
        }
    }
}