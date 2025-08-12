<?php

namespace App\Http\Controllers;

use App\Models\ObjekWisata;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DataTableController extends Controller
{
    public function clientside(Request $request){

        $objekWisata = new ObjekWisata;

        if($request->get('search')){
            $objekWisata = $objekWisata->where('nama', 'LIKE', '%'.$request->get('search').'%')
                ->orWhere('kategori', 'LIKE', '%'.$request->get('search').'%');
        }

        $objekWisata = $objekWisata->get();

        return view('datatable.clientside', compact('objekWisata', 'request'));
    }

    public function objekWisata(Request $request)
    {
        if ($request->ajax()) {
            $objekWisata = ObjekWisata::latest();

            return DataTables::of($objekWisata)
                ->addColumn('no', function($data) {
                    return ''; // akan diganti oleh JS
                })
                ->addColumn('gambar', function($data) {
                    return '<img src="'.asset('storage/wisata/'.$data->gambar).'" width="60">';
                })
                ->addColumn('nama', function($data) {
                    return $data->nama;
                })
                ->addColumn('kategori', function($data) {
                    return $data->kategori;
                })
                ->addColumn('jam_buka', function($data) {
                    return $data->jam_buka;
                })
                ->addColumn('htm', function($data) {
                    return $data->htm;
                })
                ->addColumn('kecamatan', function($data) {
                    return $data->kecamatan;
                })
                ->addColumn('action', function($data) {
                    $editUrl = route('admin.objek-wisata.edit', ['id' => $data->id]);
                    return '
                        <a href="'.$editUrl.'" class="btn btn-sm btn-primary">Edit</a>
                        <a data-toggle="modal" data-target="#modal-hapus'.$data->id.'" class="btn btn-sm btn-danger">Hapus</a>
                    ';
                })
                ->rawColumns(['gambar', 'action'])
                ->make(true);
        }

        // hanya tampilkan view jika bukan ajax
        return view('admin.objek-wisata.index');
    }
}