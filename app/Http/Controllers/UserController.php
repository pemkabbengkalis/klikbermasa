<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    private $view = 'backend.users.';
    private $module = 'users';


    public static function middleware() {
        return [
            new Middleware('auth')
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd('dff');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function data(Request $request)
    {
        return DataTables::of(User::query()->withwhereHas('instansi')->whereLevel('instansi'))
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $button = '<div class="btn-group">';
                $button .= '<a href="' . route('users.edit', $row->id) . '" class="btn btn-sm btn-warning bi bi-pencil-square"> </a>';
                $button .= '<button class="btn btn-sm btn-danger bi bi-trash" onclick="sw_delete(\'' . $row->id . '\')"></button>';
                $button .= '</div>';
                return $button;
            })
            ->addColumn('status', function ($row) {
                return $row->status == '1' ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Nonaktif</span>';
        })
        ->rawColumns(['aksi','status'])
        ->toJson();
    }

    public function create() {
        $data = [
            'data' => null
        ];
        return view($this->view . 'form', $data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,User $user)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'instansi_id' => 'required|string',
            'status' => 'required|numeric',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|min:8',
        ]);
        $data['level'] = 'instansi';
        $data['password'] = bcrypt($request->password);
        $data = $user->create($data);
        return to_route($this->module.'.edit',$data->id)->with('success', 'User Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $data = [
            'data' => $user
        ];
        return view($this->view . 'form', $data);
    }

    public function account(Request $request){
        $user = $request->user();
        if($request->isMethod('post')){
            $data = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'username' => 'required|string|unique:users,username,' . $user->id,
                'password' => 'string|confirmed|min:8|nullable',
                'password_confirmation' => 'string|nullable'
            ]);
            if ($password = $request->password) {
                $data['password'] = bcrypt($password);
            }
            $user->update($data);
        return back()->with('success', 'Akun Berhasil Diperbarui');

        }
        $data = [
            'data' => $user
        ];
        return view($this->view . 'account', $data);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'status' => 'required|numeric',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'username' => 'required|string|unique:users,username,'.$user->id,
            'password' => 'nullable|min:8',
        ]);
        if($request->has('password')){
            $data['password'] =  bcrypt($request->password);
        }
        $user->update($data);
        return back()->with('success', 'User Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (!request()->isMethod('delete'))
        return back();
        $user->delete();
        return to_route($this->module)->with('success', 'Berhasil dihapus');
    }
}
