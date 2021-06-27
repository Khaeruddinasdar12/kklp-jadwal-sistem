<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Jadwal;
use App\Departemen;
use Auth;
use Carbon\Carbon;
use DB;

class JadwalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Departemen::select('id', 'nama')->get(); //departemen
        return view('admin.jadwal', ['dpt' => $data]);
    }

    public function riwayat() //halaman riwayat jadwal
    {
        return view('admin.riwayat-jadwal');
    }

    public function edit($id)
    {
        $data = DB::table('jadwals')->select('id', 'nama', 'ruangan', 'deskripsi', 'waktu', 'departemen')->where('id', $id)->get();
        if($data == '') {
            abort(404);
        } 

        $dpt = Departemen::select('id', 'nama')->get(); //departemen
        return view('admin.edit-jadwal', [
            'data' => $data,
            'dpt' => $dpt
        ]);
    }

    public function store(Request $request)
    {
        $validasi = $this->validate($request, [
            'nama'  => 'required|string',
            'ruangan'  => 'required|string',
            'waktu'  => 'required|date', //tanggal
            'jam'  => 'required|numeric|between:0,23',
            'menit'  => 'required|numeric|between:0,59',
            'deskripsi'  => 'required|string',
        ]);

        $tgl = $request->waktu;
        $jam = $request->jam;
        $menit = $request->menit;

        $merge = $tgl.' '.$jam.':'.$menit.':00';
        $wkt = Carbon::parse($merge)->format('Y-m-d H:i:s');
        
        $data = new Jadwal;
        $data->nama = $request->nama;
        $data->waktu = $wkt;
        $data->ruangan = $request->ruangan;    
        $data->deskripsi = $request->deskripsi; 

        $input = "";
        foreach($request->departemen as $dpt)   {  
            $input .= $dpt.",";  
        } 
        $data->departemen  = $input;

        $data->user_id = Auth::user()->id; 
        $data->save();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Menambah Jadwal.'
        );
    }

    public function update(Request $request,$id)
    {
        $validasi = $this->validate($request, [
            'nama'  => 'required|string',
            'ruangan'  => 'required|string',
            'waktu'  => 'required|date', //tanggal
            'jam'  => 'required|numeric|between:0,23',
            'menit'  => 'required|numeric|between:0,59',
            'deskripsi'  => 'required|string',
        ]);

        $tgl = $request->waktu;
        $jam = $request->jam;
        $menit = $request->menit;

        $merge = $tgl.' '.$jam.':'.$menit.':00';
        $wkt = Carbon::parse($merge)->format('Y-m-d H:i:s');
        
        $data = Jadwal::findOrFail($id);
        $data->nama = $request->nama;
        $data->waktu = $wkt;
        $data->ruangan = $request->ruangan;    
        $data->deskripsi = $request->deskripsi; 

        $input = "";
        foreach($request->departemen as $dpt)   {  
            $input .= $dpt.",";  
        } 
        $data->departemen  = $input;

        $data->user_id = Auth::user()->id; 
        $data->save();

        return redirect()->back()->with('success', 'Berhasil mengubah jadwal');
    }

    public function selesai($id) //menyelesaikan jadwal
    {
        $data = Jadwal::find($id);
        if($data == '') {
            return $arrayName = array(
                'status' => 'error',
                'pesan' => 'Id Jadwal Tidak Ditemukan.'
            );
        }
        $data->user_id = Auth::user()->id;
        $data->status = '1'; //menyelesaikan jadwal
        $data->save();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Jadwal Meeting Selesai.'
        );
    }

    public function delete($id) //delete jadwal
    {
        $data = Jadwal::find($id);
        if($data == '') {
            return $arrayName = array(
                'status' => 'error',
                'pesan' => 'Id Jadwal Tidak Ditemukan.'
            );
        }
        $data->delete();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Menghapus Jadwal.'
        );
    }

    public function tableJadwal() // api table jadwal untuk datatable
    {
        $data = Jadwal::select('jadwals.id', 'jadwals.nama', 'jadwals.ruangan', 'jadwals.deskripsi', 'jadwals.waktu',DB::raw('group_concat(concat(departemens.nama)SEPARATOR ", ") as departemen'))
        ->leftjoin("departemens",\DB::raw("FIND_IN_SET(departemens.id,jadwals.departemen)"),">",\DB::raw("'0'"))
        
        ->orderBy('jadwals.waktu', 'desc')
        ->groupBy('jadwals.id')
        ->where('status', '0')
        ->get();
        
        return Datatables::of($data)
        ->addColumn('action', function ($data) {
            return "
            <button
            href='manage-jadwal/selesai/".$data->id."'
            onclick='selesai()'
            id='jadwal_id'
            class='btn btn-success btn-xs'
            title='Jadwal meeting telah selesai ?'>
            <i class='fa fa-check'></i>
            </button>

            <a href='manage-jadwal/edit/".$data->id."' 
            class='btn btn-info btn-xs'
            title='edit jadwal'>
            <i class='fa fa-edit'></i>
            </a>

            <button class='btn btn-danger btn-xs'
            title='Hapus Pengecer' 
            href='delete-jadwal/".$data->id."'
            onclick='hapus_data()'
            id='del_id'
            >
            <i class='fa fa-trash'></i>
            </button>";
        })
        ->addColumn('status', function ($data) {
            return "<span class='badge badge-pill badge-warning'>Belum terlaksana</span>";
        })
        ->editColumn('waktu', function($data){
            return $data->waktu." WITA";
        })
        ->addIndexColumn() 
        ->rawColumns(['status', 'action'])
        ->make(true);
    }

    public function tableRiwayat() // api table riwayat jadwal untuk datatable
    {
        $data = Jadwal::select('jadwals.id', 'jadwals.nama', 'jadwals.ruangan', 'jadwals.deskripsi', 'jadwals.waktu',  DB::raw('group_concat(concat(departemens.nama)SEPARATOR ", ") as departemen'))
        ->leftjoin("departemens",\DB::raw("FIND_IN_SET(departemens.id,jadwals.departemen)"),">",\DB::raw("'0'"))
        
        ->orderBy('jadwals.waktu', 'desc')
        ->groupBy('jadwals.id')
        ->where('jadwals.status', '1')
        ->get();
        
        return Datatables::of($data)
        ->addColumn('status', function ($data) {
            return "<span class='badge badge-pill badge-success'>Riwayat</span>";
        })
        ->editColumn('waktu', function($data){
            return $data->waktu." WITA";
        })
        ->addIndexColumn() 
        ->rawColumns(['status'])
        ->make(true);
    }
}
