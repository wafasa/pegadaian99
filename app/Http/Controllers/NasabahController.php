<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Akad;
use App\Models\Nasabah;

class NasabahController extends Controller
{
    public function __construct(
                                Akad $akad,
                                Nasabah $nasabah,
                                Request $request
                            )
    {
        $this->akad         = $akad;
        $this->nasabah      = $nasabah;
        $this->request      = $request;

        view()->share([
            'menu'          => 'akad',
            'subMenu'       => '',
            'menuHeader'    => config('library.menu_header'),
        ]);
    }

    public function index()
    {
    	$menu 		= 'database';
        $nasabah 	= $this->nasabah->sorted();

        $column		= config('library.column.nasabah');

        if(request('by')){
            $nasabah   = $nasabah->search(request('by'), request('q'));
        }

        $nasabah 	 = $nasabah->paginate(request('perpage', 10));

    	return  $this->template('nasabah.index', compact('nasabah', 'column', 'menu'));
    }

    public function detail($id)
    {
        return $this->nasabah->find($id);
    }

    public function edit($id)
    {
        $menu = '';

        $findNasabah = $this->nasabah->find($id);

        session()->flashInput($findNasabah->toArray());
        $action = route('nasabah.update', $id);
        $method = 'PUT';

        return  $this->template('nasabah.form', compact('action', 'method', 'menu'));
    }

    public function update($id)
    {
        $nasabah                = $this->nasabah->find($id);
        $nasabah->kota          = request('kota');
        $nasabah->alamat        = request('alamat');
        $nasabah->no_telp       = request('no_telp');
        $nasabah->jenis_id      = request('jenis_id');
        $nasabah->no_identitas  = request('no_identitas');
        $nasabah->nama_lengkap  = request('nama_lengkap');
        $nasabah->jenis_kelamin = request('jenis_kelamin');
        $nasabah->tanggal_lahir = request('tanggal_lahir');
        $nasabah->tanggal_daftar= request('tanggal_daftar');
        $nasabah->save();

        $message    = '<strong>Sukses!</strong> Data Nasabah telah di perbaharui dengan Atas Nama '.$nasabah->nama_lengkap;
        flash_message('message', $message);

        return redirect()->route('nasabah.index');
    }

    public function ajax()
    {
        if(request('type') == 'full'){
            $data = $this->nasabah->where('nama_lengkap', request('nama_nasabah'))->first();
        }else{
            $data = $this->nasabah->pluck('nama_lengkap');
        }

        return response()->json(compact('data'));
    }
}
