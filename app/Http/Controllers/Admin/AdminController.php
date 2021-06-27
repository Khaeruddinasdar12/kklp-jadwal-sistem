<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DataTables;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.admin');
    }

    public function store(Request $request)
    {

        $validasi = $this->validate($request, [
            'nama'  => 'required|string',
            'email'  => 'required|string|email|unique:users',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        $data = new User;
        $data->name = $request->nama;
        $data->email = $request->email;    
        $data->password = bcrypt($request->password); 
        $data->save();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Menambah Admin.'
        );
    }

    public function tableAdmin() // api table admin untuk datatable
    {
        $data = User::select('id', 'name', 'email')
        ->orderBy('created_at', 'desc')
        ->get();

        return Datatables::of($data)
        ->addIndexColumn() 
        ->make(true);
    }
}
