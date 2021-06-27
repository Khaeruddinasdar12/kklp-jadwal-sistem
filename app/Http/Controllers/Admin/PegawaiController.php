<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Jadwal;
use App\Departemen;
use App\Pegawai;
class PegawaiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $validasi = $this->validate($request, [
            'nip'   => 'required|string|unique:pegawais|max:100',
            'nama'  => 'required|string|max:100',
            'email'  => 'required|string|email|unique:pegawais|max:100',
            'nohp'  => 'required|string|max:20',
            'alamat'  => 'required|string|max:150',
            'departemen'  => 'required|numeric',
        ]);

        $data = new Pegawai;
        $data->nip = $request->nip;
        $data->nama = $request->nama;
        $data->email = $request->email;
        $data->nohp = $request->nohp;
        $data->alamat = $request->alamat;
        $data->departemen_id = $request->departemen;     
        $data->save();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Menambah Pegawai.'
        );
    }

    public function index()
    {
        $data = Departemen::select('id', 'nama')->get();

        return view('admin.pegawai', ['data' => $data]);
    }

    public function delete($id)
    {
        $data = Pegawai::find($id);
        if($data == '') {
            return $arrayName = array(
                'status' => 'error',
                'pesan' => 'Id Pegawai Tidak Ditemukan.'
            );
        }
        $data->delete();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Menghapus Pegawai.'
        );
    }

    public function tablePegawai() // api table pegawai untuk datatable
    {
        $data = Pegawai::select('id', 'nip', 'nama', 'email', 'nohp', 'alamat', 'departemen_id')
        ->with('departemen:id,nama')
        ->orderBy('created_at', 'desc')
        ->get();

        return Datatables::of($data)
        ->addColumn('action', function ($data) {
            return "
            <a href='' class='btn btn-success btn-xs'
            data-toggle='modal' 
            data-target='#modal-edit-pegawai'
            title='edit kategori'
            data-id='".$data->id."'
            data-nip='".$data->nip."'
            data-nama='".$data->nama."'
            data-email='".$data->email."'
            data-nohp='".$data->nohp."'
            data-alamat='".$data->alamat."'
            data-departemen='".$data->departemen_id."'
            >
            <i class='fa fa-edit'></i>
            </a>

            <button class='btn btn-danger btn-xs'
            title='Hapus Pengecer' 
            href='delete-pegawai/".$data->id."'
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
