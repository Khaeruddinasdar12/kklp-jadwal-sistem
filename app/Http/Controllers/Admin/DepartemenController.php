<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Departemen;
use App\Pegawai;
use DataTables;
class DepartemenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.departemen');
    }

    public function store(Request $request)
    {
        $validasi = $this->validate($request, [
            'nama'  => 'required|string|unique:departemens|max:50'
        ]);

        $data = new Departemen;
        $data->nama = $request->nama;
        $data->save();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Menambah Departemen.'
        );
    }

    public function update(Request $request)
    {
        $data = Departemen::find($request->hidden_id);
        if($data == '') {
            return $arrayName = array(
                'status' => 'error',
                'pesan' => 'Id Departemen Tidak Ditemukan.'
            );
        }

        if($data->nama == $request->nama) {
            return $arrayName = array(
                'status' => 'error',
                'pesan' => 'Nama departemen sama dengan nama sebelumnya'
            );
        }

        $data->nama = $request->nama;
        $data->save();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Mengubah Departemen.'
        );
    }

    public function delete($id)
    {
        if (Pegawai::where('departemen_id', $id)->exists()) {
            return $arrayName = array(
                'status' => 'error',
                'pesan' => 'Tidak dapat menghapus departemen, ada pegawai dari departemen ini'
            );
        }

        $data = Departemen::find($id);
        if($data == '') {
            return $arrayName = array(
                'status' => 'error',
                'pesan' => 'Id Departemen Tidak Ditemukan.'
            );
        }
        $data->delete();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Menghapus Departemen.'
        );
    }

    public function tableDepartemen() // api table departemen untuk datatable
    {
        $data = Departemen::select('id', 'nama')
        ->orderBy('created_at', 'desc')
        ->get();

        return Datatables::of($data)
        ->addColumn('action', function ($data) {
            return "
            <a href='' class='btn btn-success btn-xs'
            data-toggle='modal' 
            data-target='#modal-edit-departemen'
            title='edit departemen'
            data-id='".$data->id."'
            data-nama='".$data->nama."'>
            <i class='fa fa-edit'></i>
            </a>

            <button class='btn btn-danger btn-xs'
            title='Hapus Departemen' 
            href='delete-departemen/".$data->id."'
            onclick='hapus_data()'
            id='del_id'
            >
            <i class='fa fa-trash'></i>
            </button>";
        })
        ->addIndexColumn() 
        ->make(true);
    }
}
