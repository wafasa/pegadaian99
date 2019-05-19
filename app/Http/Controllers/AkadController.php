<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Akad;
use App\Models\Nasabah;
use App\Models\Setting;
use App\Models\User_cabang;

use Carbon\Carbon;
use Auth;

class AkadController extends Controller
{
    public function __construct(
    							Akad $akad,
    							Nasabah $nasabah,
                                Setting $setting,
    							Request $request,
                                User_cabang $user_cabang
                            )
    {
    	$this->akad 		= $akad;
    	$this->nasabah 		= $nasabah;
        $this->setting      = $setting;
    	$this->request  	= $request;
        $this->user_cabang  = $user_cabang;

        view()->share([
            'menu'          => 'database',
            'subMenu'       => 'akad',
            'menuHeader'    => config('library.menu_header'),
        ]);
    }

    /* code tab-tab in data akad nasabah :
    * na    = nasabah akad
    * ajt   = akad jatuh tempo
    * pl    = pelunasan dan lelang
    */

    public function index()
    {
        // return config('menu.menu_header');

        // name menu for active menu header
        $menu           = 'database';

        // list table per tab
    	$nasabahAkad    = $this->nasabahAkad();
        // akadJatuhTempo data array tables base on sum 'jatuh tempo hari'
        $akadJatuhTempo = $this->akadJatuhTempo();
        $pelunasanLelang= $this->pelunasanLelang();

        // list column per TAB :
        // column for 'akad jatuh tempo'
        $columnAkadJatuhTempo   = config('library.column.akad_nasabah.akad_jatuh_tempo');
        // column for 'nasabah akad'
        $columnListNasabahAkad  = config('library.column.akad_nasabah.list_akad_nasabah');
        // column for 'pelunasan & lelang'
        $columnPelunasanLelang  = config('library.column.akad_nasabah.pelunasan_dan_lelang');

    	return $this->template('akad._index', compact(
            'nasabahAkad', 'akadJatuhTempo', 'pelunasanLelang', 'menu', 
            'columnAkadJatuhTempo', 'columnListNasabahAkad', 'columnPelunasanLelang'
        ));
    }

    //SUB MENU
    public function nasabah_akad()
    {
         // name menu for active menu header
        $menu    = 'database';
        $subMenu = 'akad';
        // name field 'tanggal jatuh tempo' for sorted
        $nameFieldSorted= 'akad.tanggal_jatuh_tempo';
        
        $nasabahAkad    = $this->akad->nasabah()->sorted($nameFieldSorted, 'desc')->baseBranch();

        if(request('perpage_na')){
            // if get data from range date
            if(request('daterange')){
                $end    = carbon::parse(substr(request('daterange'), 13, 20));
                $start  = carbon::parse(substr(request('daterange'), 1, 9));
            }

            // scope function filterRange
            $nasabahAkad= $nasabahAkad->filterRange($start, $end);
            $dateRange  = $start->format('m/d/Y').' - '.$end->format('m/d/Y');
        }else{
            // for default date in form filter date range
            $end        = Carbon::now()->day(30);
            $start      = Carbon::now()->day(1);

            // format dateRange base on template
            $dateRange  = $start->format('m/d/Y').' - '.$end->format('m/d/Y');
        }

        $nasabahAkad    = $this->filter($nasabahAkad, 'na')->akad->paginate(request('perpage_na', 10));

        // column for 'nasabah akad'
        $columnListNasabahAkad  = config('library.column.akad_nasabah.list_akad_nasabah');

        return $this->template('akad.index.baru.nasabah-akad', compact(
            'nasabahAkad', 'dateRange', 'menu', 'subMenu', 'columnListNasabahAkad'
        ));
    }

    public function akad_jatuh_tempo()
    {
        return 'akad jatuh tempo';
    }

    public function pelunasan_lelang()
    {
        return 'pelunasan lelang';
    }

    public function lokasi_distribusi()
    {
        return 'lokasi distribusi';
    }

    public function maintenance()
    {
        return 'maintenance';
    }

    // 'NASABAH AKAD'
    public function nasabahAkad() 
    {
        // name field 'tanggal jatuh tempo' for sorted
        $nameFieldSorted= 'akad.tanggal_jatuh_tempo';

        $nasabahAkad    = $this->akad->nasabah()->sorted($nameFieldSorted, 'desc')->baseBranch();

        if(request('perpage_na')){
            // if get data from range date
            if(request('daterange')){
                $end    = carbon::parse(substr(request('daterange'), 13, 20));
                $start  = carbon::parse(substr(request('daterange'), 1, 9));
            }

            // scope function filterRange
            $nasabahAkad= $nasabahAkad->filterRange($start, $end);
            $dateRange  = $start->format('m/d/Y').' - '.$end->format('m/d/Y');
        }else{
            // for default date in form filter date range
            $end        = Carbon::now()->day(30);
            $start      = Carbon::now()->day(1);

            // format dateRange base on template
            $dateRange  = $start->format('m/d/Y').' - '.$end->format('m/d/Y');
        }

        $data           = $this->filter($nasabahAkad, 'na')->akad->paginate(request('perpage_na', 10));

        return (object) compact('data', 'dateRange');
    }

    // 'AKAD JATUH TEMPO'
    public function akadJatuhTempo()
    {
        $now = Carbon::now()->format('Y-m-d');

        // list name tables on TAB 'akad jatuh tempo' example list 'jatuh tempo 7 hari', '15 hari' etc.
        $nameTables     = config('library.name_tables.akad_nasabah.akad_jatuh_tempo');
        // name field 'tanggal jatuh tempo' for sorted
        $nameFieldSorted= 'akad.tanggal_jatuh_tempo';
        // 7,15,30,60 days of data
        $sixty          = $this->akad->nasabah()->belumLunas()->sorted($nameFieldSorted, 'desc');
        $thirty         = $this->akad->nasabah()->belumLunas()->sorted($nameFieldSorted, 'desc');
        $sevenDays      = $this->akad->nasabah()->belumLunas()->sorted($nameFieldSorted, 'desc');
        $fifteenDays    = $this->akad->nasabah()->belumLunas()->sorted($nameFieldSorted, 'desc');

        // addDay is scope function
        $nameTables[0]['data']  = $this->filter($sevenDays, 'ajt_7')->akad->addDay('7', 1)->paginate(request('perpage_ajt_7', 10));
        $nameTables[1]['data']  = $this->filter($fifteenDays, 'ajt_15')->akad->addDay('15', 2)->paginate(request('perpage_ajt_15', 10));
        $nameTables[2]['data']  = $this->filter($thirty, 'ajt_30')->akad->addDay('30', 7)->paginate(request('perpage_ajt_30', 10));
        $nameTables[3]['data']  = $this->filter($sixty, 'ajt_60')->akad->addDay('60', 7)->paginate(request('perpage_ajt_60', 10));
        $nameTables[4]['data']  = $this->filter($sixty, 'ajt_60')->akad->addDay('60', 7)->paginate(request('perpage_ajt_60', 10));
        $nameTables[5]['data']  = $this->filter($sixty, 'ajt_60')->akad->addDay('60', 7)->paginate(request('perpage_ajt_60', 10));
        $nameTables[6]['data']  = $this->filter($sixty, 'ajt_60')->akad->addDay('60', 7)->paginate(request('perpage_ajt_60', 10));
        $nameTables[7]['data']  = $this->filter($sixty, 'ajt_60')->akad->addDay('60', 7)->paginate(request('perpage_ajt_60', 10));

        return $nameTables;
    }

    // 'PELUNASAN DAN LELANG'
    public function pelunasanLelang()
    {
        // code is code tab pl = 'pelunasan & lelang'
        $code   = 'pl_';
        $perpage= 'perpage_';

        // list name tables on TAB 'pelunasan dan lelang' example list 'nasabah lunas, lelang, dan refund'.
        $nameTables     = config('library.name_tables.akad_nasabah.pelunasan_dan_lelang');

        // data of list nasabah lunas, lelang, refund
        $lunas          = $this->akad->nasabah()->lunas()->sorted('akad.tanggal_jatuh_tempo', 'desc');
        $refund         = $this->akad->nasabah()->refund()->sorted('akad.tanggal_jatuh_tempo', 'desc');
        $lelang         = $this->akad->nasabah()->lelang()->sorted('akad.tanggal_jatuh_tempo', 'desc');

        //proccess insert data array into variable nameTables
        $nameTables[0]['data'] = $this->filter($lunas, $code.'lunas')->akad->paginate(request($perpage.$code.'lunas', 10));
        $nameTables[1]['data'] = $this->filter($lelang, $code.'lelang')->akad->paginate(request($perpage.$code.'lelang', 10));
        $nameTables[2]['data'] = $this->filter($refund, $code.'refund')->akad->paginate(request($perpage.$code.'refund', 10));

        return $nameTables;
    }

    //for filter data from perpage, and query in file view akad.index
    public function filter($akad, $code)
    {
        // if get data from input keyword 
        if(request('q_'.$code)){
            $akad   = $akad->search(request('by_'.$code), request('q_'.$code));
        }

        return (object) compact('akad');
    }

    public function create()
    {
    	return $this->form();
    }

    public function edit($id)
    {
    	return $this->form($id);
    }

    public function form($id = null)
    {
    	$tanggal_akad	     = Carbon::now()->format('d-m-Y');
    	$tanggal_jatuh_tempo = Carbon::now()->addDay('7')->format('d-m-Y');

        // list time example : 1, 7, 15, 30, 60 days. for 'jangka_waktu_akad' and 'opsi_pembayaran'
        $listTime            = config('library.form.akad.list_time');
        $paymentOption       = config('library.form.akad.payment_option');

        // 'margin dan potongan elektronik'
        $margin_elektronik      = $this->setting->baseBranch()->jenisBarang('elektronik')->value('margin');
        $potongan_elektronik    = $this->setting->baseBranch()->jenisBarang('elektronik')->value('potongan');

        // 'margin dan potongan kendaraan'
        $margin_kendaraan       = $this->setting->baseBranch()->jenisBarang('kendaraan')->value('margin');
        $potongan_kendaraan     = $this->setting->baseBranch()->jenisBarang('kendaraan')->value('potongan');

    	return $this->template('akad._form', compact(
             'tanggal_akad', 'tanggal_jatuh_tempo', 
            'listTime', 'paymentOption', 'potongan_kendaraan', 'potongan_elektronik', 'margin_kendaraan', 'margin_elektronik'
        ));
    }

    public function send()
    {
    	return $this->save();
    }

    public function update($id)
    {
    	return $this->save($id);
    }

    public function save($id = null)
    {
        $data       = [];
        $input 		= $this->request->except('_token');
        $input      = $input['data'];
    	$id_cabang	= $this->user_cabang->baseUsername()->value('id_cabang');
        
        foreach ($input as $index => $item) {
            $data[$item['name']] = $item['value'];
        }

        return $data;

    	// $nasabah 				= $this->nasabah;
    	// $nasabah->key_nasabah 	= uniqid();
    	// $nasabah->nama_lengkap	= request('nama_lengkap');
    	// $nasabah->jenis_kelamin	= request('jenis_kelamin');
    	// $nasabah->kota			= request('kota');
    	// $nasabah->no_telp		= request('no_telp');
    	// $nasabah->jenis_id		= request('jenis_id');
    	// $nasabah->no_identitas	= request('no_identitas');
    	// $nasabah->tanggal_lahir	= request('tanggal_lahir');
    	// $nasabah->alamat		= request('alamat');
    	// $nasabah->tanggal_daftar= Carbon::now()->format('Y-m-d');
    	// $nasabah->save();

    	// $akad 						  = $this->akad;
    	// $akad->id_cabang 			  = $id_cabang;
    	// $akad->no_id 				  = request('no_id');
    	// $akad->key_nasabah 			  = $nasabah->key_nasabah;
    	// $akad->nama_barang			  = request('nama_barang'); 
    	// $akad->jenis_barang			  = request('jenis_barang'); 
    	// $akad->kelengkapan			  = request('kelengkapan'); 
        // $akad->kelengkapan_barang_satu= request('kelengkapan_barang_satu'); 
        // $akad->kelengkapan_barang_dua = request('kelengkapan_barang_dua'); 
        // $akad->kelengkapan_barang_tiga= request('kelengkapan_barang_tiga'); 
    	// $akad->kekurangan			  = request('kekurangan'); 
    	// $akad->jangka_waktu_akad	  = number_format(request('jangka_waktu_akad')); 
    	// $akad->tanggal_akad			  = request('tanggal_akad'); 
    	// $akad->tanggal_jatuh_tempo	  = request('tanggal_jatuh_tempo'); 
    	// $akad->nilai_tafsir			  = remove_dot(request('taksiran_marhun')); 
    	// $akad->nilai_pencairan		  = remove_dot(request('marhun_bih')); 
    	// $akad->bt_7_hari			  = remove_dot(request('biaya_titip')); 
    	// $akad->biaya_admin			  = request('biaya_admin'); 
    	// $akad->terbilang			  = request('terbilang'); 
    	// $akad->status				  = 'Belum Lunas';
    	// $akad->save(); 

        $message    = '<strong>Sukses!</strong> Data Akad Nasabah berhasil di tambahkan';
        flash_message('message', $message);

    	return redirect()->route('akad.index');
    }

    public function destroy($id)
    {

    }

}
