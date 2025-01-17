<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Panel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $version = config('master.initial_version');
        if ($request->is($version . '/layanan') || $request->is($version . '/layanan/*/edit') || $request->is($version . '/layanan/create')) {
            config([
                'menu.active' => [
                    'name' => 'Layanan',
                    'title' => $this->crud_type($request->segment(4)).' Layanan',
                    'path' => 'layanan',
                    'description' => 'Menu untuk mengelola layanan',
                    'icon' => 'fa-list',
                ]
            ]);
        }
        if ($request->is($version . '/instansi') || $request->is($version . '/instansi/*/edit') || $request->is($version . '/instansi/create')) {
            config([
                'menu.active' => [
                    'name' => 'Instansi',
                    'title' => $this->crud_type($request->segment(4)).' Instansi',
                    'path' => 'instansi',
                    'description' => 'Menu untuk mengelola Instansi',
                    'icon' => 'fa-list',
                ]
            ]);
        }
        if ($request->is($version . '/kategori') || $request->is($version . '/kategori/*/edit') || $request->is($version . '/kategori/create')) {
            config([
                'menu.active' => [
                    'name' => 'Kategori',
                    'title' => $this->crud_type($request->segment(4)).' Kategori',
                    'path' => 'kategori',
                    'description' => 'Menu untuk mengelola Kategori',
                    'icon' => 'fa-list',
                ]
            ]);
        }
        if ($request->is($version . '/user') || $request->is($version . '/user/*/edit') || $request->is($version . '/user/create')) {
            config([
                'menu.active' => [
                    'name' => 'Pengguna',
                    'title' => $this->crud_type($request->segment(4)).' Pengguna',
                    'path' => 'pengguna',
                    'description' => 'Menu untuk mengelola Pengguna',
                    'icon' => 'fa-user',
                ]
            ]);
        }
        return $next($request);
    }

    function crud_type($segment=null){
        return match($segment){
            'edit'=>'Edit',
            'create'=>'Tambah',
            default=>'Daftar',
       };
    }
}
