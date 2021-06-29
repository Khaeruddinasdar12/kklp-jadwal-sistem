<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jadwal;
use App\Pegawai;
use App\User;
use App\Departemen;
use DB;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function main()
    {
        $data = Jadwal::select('jadwals.id', 'jadwals.nama', 'jadwals.ruangan', 'jadwals.deskripsi', 'jadwals.waktu',DB::raw('group_concat(concat(departemens.nama)SEPARATOR ", ") as departemen'))
        ->leftjoin("departemens",\DB::raw("FIND_IN_SET(departemens.id,jadwals.departemen)"),">",\DB::raw("'0'"))
        
        ->orderBy('jadwals.waktu', 'asc')
        ->groupBy('jadwals.id')
        ->where('status', '0')
        ->limit(6)
        ->get();

        return view('main', ['data'=>$data]);
    }
    
    public function index()
    {
        $jdw = Jadwal::where('status', '0')->count(); // jumlah jadwal menunggu
        $adm = User::count();
        $pgw = Pegawai::count();
        $dpt = Departemen::count();
        return view('admin.dashboard',[
            'jdw' => $jdw,
            'adm' => $adm,
            'pgw' => $pgw,
            'dpt' => $dpt
        ]);
    }
}
