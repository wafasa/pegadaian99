<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Akad;
use App\Models\Nasabah;
use App\Models\Setting;
use App\Models\Kas_cabang;
use App\Models\Biaya_titip;
use App\Models\User_cabang;
use App\Models\Saldo_cabang;

use App\Models\Log\Log_akad;
use App\Models\Log\Log_kas_cabang;
use App\Models\Log\Log_saldo_cabang;

use Auth;
use Terbilang;
use Carbon\Carbon;

class AkadController extends Controller
{
    public function __construct(
    							Akad $akad,
    							Nasabah $nasabah,
                                Setting $setting,
    							Request $request,
                                Log_akad $log_akad,
                                Kas_cabang $kas_cabang,
                                biaya_titip $biaya_titip,
                                User_cabang $user_cabang,
                                Log_kas_cabang $log_kas_cabang,
                                Saldo_cabang $saldo_cabang,
                                Log_saldo_cabang $log_saldo_cabang
                            )
    {
    	$this->akad 		    = $akad;
    	$this->nasabah 		    = $nasabah;
        $this->setting          = $setting;
    	$this->request  	    = $request;
        $this->log_akad         = $log_akad;
        $this->kas_cabang       = $kas_cabang;
        $this->biaya_titip      = $biaya_titip;
        $this->user_cabang      = $user_cabang;
        $this->saldo_cabang     = $saldo_cabang;
        $this->log_kas_cabang   = $log_kas_cabang;
        $this->log_saldo_cabang = $log_saldo_cabang;

        view()->share([
            'menu'          => 'database',
            'subMenu'       => 'akad',
            'menuHeader'    => config('library.menu_header'),
        ]);
    }

    /* code-code on data akad nasabah :
    * na    = nasabah akad
    * ajt   = akad jatuh tempo
    * pl    = pelunasan dan lelang
    * ld    = lokasi atau distribusi
    * m     = maintenance
    */

    //SUB MENU
    public function nasabah_akad()
    {
        // name menu for active menu header
        $menu    = 'database';
        $subMenu = 'akad';

        $harian         = $this->harian();
        $tujuh          = $this->tujuh();
        $limaBelas      = $this->limaBelas();
        $seluruhData    = $this->seluruhData();

        $column             = config('library.column.akad_nasabah.list_akad_nasabah');
        // 'waktu akad' example 'selutuh data, harian, 7 hari, 15 hari, ringkasan harian'
        $waktuAkad          = config('library.special.nasabah_akad.waktu_akad');
        $jangkaWaktuAkad    = config('library.special.nasabah_akad.jangka_waktu_akad');
        $detailJenisBarang  = config('library.special.nasabah_akad.detail_jenis_barang');

        return $this->template('akad.index.nasabah-akad', compact(
            'dateRange', 'menu', 'subMenu', 'jangkaWaktuAkad',
            'column', 'detailJenisBarang', 'waktuAkad',
            'seluruhData', 'harian', 'tujuh', 'limaBelas'
        ));
    }

    public function seluruhData()
    {
        // name field 'tanggal jatuh tempo' for sorted
        $nameFieldSorted= 'akad.tanggal_akad';
        
        $akad           = $this->akad->joinNasabah()->sorted($nameFieldSorted, 'desc')->baseBranch();
        $seluruhData    = $this->filter($akad, 'seluruh_data')->akad;
        $data           = $seluruhData->paginate(request('perpage', 10));

        $dateRange      = $this->filter($akad, 'seluruh_data')->dateRange;

        return (object) compact('data', 'dateRange'); 
    }

    public function harian()
    {
        $nameFieldSorted= 'akad.tanggal_akad';
        
        $akad           = $this->akad->joinNasabah()->sorted($nameFieldSorted, 'desc')->baseBranch();
        $akad           = $akad->opsiPembayaran(1);
        $harian         = $this->filter($akad, 'harian')->akad;
        $data           = $harian->paginate(request('perpage', 10));

        $dateRange      = $this->filter($akad, 'harian')->dateRange;

        return (object) compact('data', 'dateRange'); 
    }

    public function tujuh()
    {
        $nameFieldSorted= 'akad.tanggal_akad';
        
        $akad           = $this->akad->joinNasabah()->sorted($nameFieldSorted, 'desc')->baseBranch();
        $akad           = $akad->opsiPembayaran(7);
        $tujuh          = $this->filter($akad, 'tujuh_hari')->akad;
        $data           = $tujuh->paginate(request('perpage', 10));

        $dateRange      = $this->filter($akad, 'tujuh_hari')->dateRange;

        return (object) compact('data', 'dateRange'); 
    }

    public function limaBelas()
    {
        $nameFieldSorted= 'akad.tanggal_akad';
        
        $akad           = $this->akad->joinNasabah()->sorted($nameFieldSorted, 'desc')->baseBranch();
        $akad           = $akad->opsiPembayaran(15);
        $limaBelas      = $this->filter($akad, 'lima_belas_hari')->akad;
        $data           = $limaBelas->paginate(request('perpage', 10));

        $dateRange      = $this->filter($akad, 'lima_belas_hari')->dateRange;

        return (object) compact('data', 'dateRange'); 
    }

    public function akad_jatuh_tempo()
    {
        // column for 'akad jatuh tempo'
        $column     = config('library.column.akad_nasabah.akad_jatuh_tempo');
        // list name tables on TAB 'akad jatuh tempo' example list 'jatuh tempo 7 hari', '15 hari' etc.
        $nameTables = config('library.name_tables.akad_nasabah.akad_jatuh_tempo');

        // name field 'tanggal jatuh tempo' for sorted
        $nameFieldSorted= 'akad.tanggal_jatuh_tempo';

        $akadJatuhTempo = $this->akad->joinNasabah();
        $akadJatuhTempo = $akadJatuhTempo->baseBranch();
        $akadJatuhTempo = $akadJatuhTempo->belumLunas();
        $akadJatuhTempo = $akadJatuhTempo->sorted($nameFieldSorted, 'desc');

        // if(request('jenis_ajt')){
            $akadJatuhTempo = $akadJatuhTempo->addDay(request('jenis_ajt', '30'), request('interval', 7));
        // }

        // if get data from input keyword 
        if(request('q')){
            $akadJatuhTempo   = $akadJatuhTempo->search(request('by'), request('q'));
        }

        $data = $akadJatuhTempo->paginate(request('perpage', 10));

        return $this->template('akad.index.akad-jatuh-tempo', compact(
            'nameTables', 'column', 'data'
        ));
    }

    public function pelunasan_lelang()
    {
        $column     = config('library.column.akad_nasabah.pelunasan_dan_lelang.'.request('jenis_pl', 'lunas'));

        // list name tables on TAB 'pelunasan dan lelang' example list 'nasabah lunas, lelang, dan refund'.
        $nameTables = config('library.name_tables.akad_nasabah.pelunasan_dan_lelang');

        $pelunasanLelang    = $this->akad->joinNasabah();
        $pelunasanLelang    = $pelunasanLelang->baseBranch();
        $pelunasanLelang    = $pelunasanLelang->sorted('akad.tanggal_jatuh_tempo', 'desc');

        // if(request('jenis_pl')){
            $pelunasanLelang= $pelunasanLelang->lunas();
        // }

        // if get data from input keyword 
        if(request('q')){
            $pelunasanLelang   = $pelunasanLelang->search(request('by'), request('q'));
        }

        $data = $pelunasanLelang->paginate(request('perpage', 10));

        return $this->template('akad.index.pelunasan-lelang', compact(
            'nameTables', 'data', 'column'
        ));
    }

    public function lokasi_distribusi()
    {
        // list name tables on TAB 'pelunasan dan lelang' example list 'nasabah lunas, lelang, dan refund'.
        $nameTables = config('library.name_tables.lokasi_distribusi');

        $lokasiDistribusi    = $this->akad->joinNasabah();
        $lokasiDistribusi    = $lokasiDistribusi->baseBranch();
        $lokasiDistribusi    = $lokasiDistribusi->sorted('akad.tanggal_akad', 'desc');

        // filter data base on field 'status lokasi'
        if(request('jenis_ld')){
            $lokasiDistribusi= $lokasiDistribusi->statusLokasi(request('jenis_ld'));
        }

        // if get data from input keyword 
        if(request('q')){
            $lokasiDistribusi= $lokasiDistribusi->search('akad.nama_barang', request('q'));
        }

        $data = $lokasiDistribusi->paginate(request('perpage', 10));

        return $this->template('akad.index.lokasi-distribusi', compact(
            'nameTables', 'data'
        ));
    }

    public function change_location($id, $type)
    {
        $akad = $this->akad->find($id);
        
        if($type == 'send'){
            if($akad->status_lokasi == null || $akad->status_lokasi == 'kantor'){
                $akad->status_lokasi = 'proses';
                $akad->target_lokasi = 'gudang';
            }elseif($akad->status_lokasi == 'proses' && $akad->target_lokasi == 'gudang'){
                $akad->status_lokasi = 'gudang';
                $akad->target_lokasi = 'kantor';
            }elseif($akad->status_lokasi == 'proses' && $akad->target_lokasi == 'kantor'){
                $akad->status_lokasi = 'kantor';
                $akad->target_lokasi = 'gudang';
            }elseif($akad->status_lokasi == 'gudang' && $akad->target_lokasi == 'kantor'){
                $akad->status_lokasi = 'proses';
                $akad->target_lokasi = 'kantor';
            }
        }else{
            if($akad->target_lokasi == 'gudang'){
                $akad->status_lokasi = 'kantor';
                $akad->target_lokasi = 'gudang';
            }elseif($akad->target_lokasi == 'kantor'){
                $akad->status_lokasi = 'gudang';
                $akad->target_lokasi = 'kantor';
            }
        }

        $akad->save();

        return redirect()->back();
    }

    public function maintenance()
    {
        // list column maintenance
        $column     = config('library.column.akad_nasabah.maintenance');
        // list name tables on TAB 'pelunasan dan lelang' example list 'nasabah lunas, lelang, dan refund'.
        $nameTables = config('library.name_tables.lokasi_distribusi');

        $maintenance    = $this->akad->joinNasabah();
        $maintenance    = $maintenance->baseBranch();
        $maintenance    = $maintenance->sorted('akad.maintenance');
        $maintenance    = $maintenance->sorted('tanggal_akad', 'desc');
        $maintenance    = $maintenance->maintenance();

        // if get data from input keyword 
        if(request('q')){
            $maintenance   = $maintenance->search(request('by'), request('q'));
        }

        $data = $maintenance->paginate(request('perpage', 10));

        return $this->template('akad.index.maintenance', compact(
            'nameTables', 'data', 'column'
        ));
    }

    public function change_checklist($id)
    {
        $akad = $this->akad->find($id);

        if($akad->maintenance == 0){
            $akad->maintenance = 1;
        }else{
            $akad->maintenance = 0;
        }

        $akad->save();

        return redirect()->back();
    }

    //for filter data from perpage, and query in file view akad.index
    public function filter($akad, $nameTab = null)
    {
        if(request('name_tab', 'seluruh_data') == $nameTab){
            if(request('daterange') != null){
                // if get data from range date
                // if(request('daterange')){
                    $end    = carbon::parse(substr(request('daterange'), 13, 20));
                    $start  = carbon::parse(substr(request('daterange'), 1, 9));
                // }
    
                // scope function filterRange
                $akad       = $akad->filterRange($start, $end);
                $dateRange  = $start->format('m/d/Y').' - '.$end->format('m/d/Y');
            }else{
                // for default date in form filter date range
                $end        = Carbon::now()->day(30);
                $start      = Carbon::now()->day(1);
    
                // format dateRange base on template
                $dateRange  = $start->format('m/d/Y').' - '.$end->format('m/d/Y');
            }
    
            // if get data from input keyword 
            if(request('q')){
                $akad   = $akad->search(request('by'), request('q'));
            }

            if(request('detail_jenis_barang')){
                $akad   = $akad->detailJenisBarang(request('detail_jenis_barang'));
            }

            if(request('opsi_pembayaran')){
                $akad   = $akad->opsiPembayaran(request('opsi_pembayaran'));
            }

            if(request('jangka_waktu_akad')){
                $akad   = $akad->jangkaWaktuAkad(request('jangka_waktu_akad'));
            }
        }else{
            // for default date in form filter date range
            $end        = Carbon::now()->day(30);
            $start      = Carbon::now()->day(1);

            // format dateRange base on template
            $dateRange  = $start->format('m/d/Y').' - '.$end->format('m/d/Y');
        }

        

        return (object) compact('akad', 'dateRange');
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
        $menu = 'akad';
        $subMenu = '';

        // value default 'tanggal akad' and 'tanggal jatuh tempo'
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

        $noId = $this->codeNoId()->value;

    	return $this->template('akad._form', compact(
             'tanggal_akad', 'tanggal_jatuh_tempo', 'menu', 'subMenu', 'noId',
            'listTime', 'paymentOption', 'potongan_kendaraan', 'potongan_elektronik', 'margin_kendaraan', 'margin_elektronik'
        ));
    }

    public function codeNoId()
    {
        $codeNoId       = 'C99-'.$this->infoCabang()->nomorCabang.'-'.Carbon::now()->format('dmy');

        // 'mendapatkan jumlah akad ke-berapa pada hari ini'
        $contractToday  = $this->log_akad->where('no_id', 'LIKE', '%'.$codeNoId.'%')->count();
        $contractToday  = $contractToday + 1;
        $contractToday  = $contractToday >= 10 ? '-0'.$contractToday : '-00'.$contractToday;
        
        $value          = $codeNoId . $contractToday;

        return (object) compact('value');
    }

    public function store()
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

        $nasabah = $this->insert_nasabah($data)->data;

    	$akad 						  = $this->akad;
    	$akad->id_cabang 			  = $id_cabang;
    	$akad->no_id 				  = $data['no_id'];
    	$akad->key_nasabah 			  = $nasabah->key_nasabah;
    	$akad->nama_barang			  = $data['nama_barang']; 
    	$akad->jenis_barang			  = $data['jenis_barang']; 
    	$akad->detail_jenis_barang	  = $data['detail_jenis_barang']; 
    	$akad->kelengkapan			  = $data['kelengkapan']; 
        $akad->kelengkapan_barang_satu= $data['kelengkapan_barang_satu']; 
        $akad->kelengkapan_barang_dua = $data['kelengkapan_barang_dua']; 
        $akad->kelengkapan_barang_tiga= $data['kelengkapan_barang_tiga']; 
    	$akad->kekurangan			  = $data['kekurangan']; 
    	$akad->jangka_waktu_akad	  = number_format($data['jangka_waktu_akad']); 
    	$akad->tanggal_akad			  = Carbon::parse($data['tanggal_akad'])->format('Y-m-d'); 
    	$akad->tanggal_jatuh_tempo	  = Carbon::parse($data['tanggal_jatuh_tempo'])->format('Y-m-d'); 
    	$akad->nilai_tafsir			  = remove_dot($data['taksiran_marhun']); 
    	$akad->nilai_pencairan		  = remove_dot($data['marhun_bih']); 
    	$akad->bt_7_hari			  = remove_dot($data['biaya_titip']); 
    	$akad->bt_ke			      = $data['bt_yang_dibayar']; 
    	$akad->biaya_admin			  = remove_dot($data['biaya_admin']); 
    	$akad->terbilang			  = $data['terbilang']; 
    	$akad->status				  = 'Belum Lunas';
    	$akad->status_lokasi    	  = 'kantor';
        $akad->save();

        // insert data to other table
        $bea_titip                    = $this->insert_bea_titip($akad);
        $kas_cabang                   = $this->insert_kas_cabang($akad);
        $saldo_cabang                 = $this->insert_saldo_cabang($akad);

        $log_akad                     = $this->insert_log_akad($akad);
        $log_kas_cabang               = $this->insert_log_kas_cabang($akad, $nasabah);
        $log_saldo_cabang             = $this->insert_log_saldo_cabang($akad, $nasabah);
    }

    public function insert_nasabah($data)
    {
        $findNasabah = $this->nasabah->where('nama_lengkap', $data['nama_lengkap'])->first();

        if(!$findNasabah){
            $nasabah 				= $this->nasabah;
            $nasabah->key_nasabah 	= uniqid();
            $nasabah->nama_lengkap	= $data['nama_lengkap'];
            $nasabah->jenis_kelamin	= $data['jenis_kelamin'];
            $nasabah->kota			= $data['kota'];
            $nasabah->no_telp		= $data['no_telp'];
            $nasabah->jenis_id		= $data['jenis_id'];
            $nasabah->no_identitas	= $data['no_identitas'];
            $nasabah->tanggal_lahir	= $data['tanggal_lahir'];
            $nasabah->alamat		= $data['alamat'];
            $nasabah->tanggal_daftar= Carbon::now()->format('Y-m-d');
            $nasabah->save();

            $data = $nasabah;
        }else{
            $data = $findNasabah;
        }

        return (object) compact('data');
    }

    public function insert_bea_titip($data)
    {
        if(reqeust('bt_yang_dibayar') >= 1){
            $biaya_titip                        = $this->biaya_titip;
            $biaya_titip->no_id                 = $data->no_id;
            $biaya_titip->keterangan            = 'KE 1-'.request('bt_yang_dibayar');
            $biaya_titip->pembayaran            = $data->bt_7_hari;
            $biaya_titip->biaya_titip_ke        = request('bt_yang_dibayar');
            $biaya_titip->tanggal_pembayaran    = Carbon::now()->format('Y-m-d');
        }
    }

    public function insert_kas_cabang($data)
    {
        $findKasCabang = $this->kas_cabang->where('id_cabang', $data->id_cabang)->first();

        if($findKasCabang){
            // add up 'total kas' with new income 'biaya admin' 
            $biayaAdmin = $findKasCabang->total_kas + $data->biaya_admin;

            $kasCabang = $this->kas_cabang->where('id_cabang', $data->id_cabang);
            $kasCabang->update(['total_kas' => $biayaAdmin]);
        }else{
            $kasCabang = $this->kas_cabang;
            $kasCabang->id_cabang  = $data->id_cabang;
            $kasCabang->total_kas  = $data->biaya_admin;
            $kasCabang->save();
        }   
    }

    public function insert_saldo_cabang($data)
    {
        $findSaldoCabang = $this->saldo_cabang->where('id_cabang', $data->id_cabang)->first();

        // add up 'total saldo' with new income 'biaya admin' 
        $marhunBih = $findSaldoCabang->total_saldo - $data->nilai_pencairan;

        $kasCabang = $this->saldo_cabang->where('id_cabang', $data->id_cabang);
        $kasCabang->update(['total_saldo' => $marhunBih]);
    }

    public function insert_log_akad($akad)
    {
        $logAkad = $this->log_akad;
        $logAkad->no_id         = $akad->no_id;
        $logAkad->status        = 'Belum Lunas';
        $logAkad->tanggal_log   = $akad->tanggal_akad;
        $logAkad->save();

        return $logAkad;
    }

    public function insert_log_saldo_cabang($akad, $nasabah)
    {
        //'marhun bih'
        $marhunBih = new Log_saldo_cabang;
        $marhunBih->jenis               = 'kredit';
        $marhunBih->jumlah              = $akad->nilai_pencairan;
        $marhunBih->id_cabang           = $akad->id_cabang;
        $marhunBih->keterangan          = 'AKAD A/N '.$nasabah->nama_lengkap;
        $marhunBih->tanggal_log_saldo   = $akad->tanggal_akad;
        $marhunBih->save();

        //'biaya admin'
        $biayaAdmin = new Log_saldo_cabang;
        $biayaAdmin->jenis               = 'debit';
        $biayaAdmin->jumlah              = $akad->biaya_admin;
        $biayaAdmin->id_cabang           = $akad->id_cabang;
        $biayaAdmin->keterangan          = 'B.ADM AKAD A/N '.$nasabah->nama_lengkap;
        $biayaAdmin->tanggal_log_saldo   = $akad->tanggal_akad;
        $biayaAdmin->save();
    }

    public function insert_log_kas_cabang($akad, $nasabah)
    {
        //'marhun bih'
        $marhunBih = new Log_kas_cabang;
        $marhunBih->jenis               = 'kredit';
        $marhunBih->jumlah              = $akad->nilai_pencairan;
        $marhunBih->id_cabang           = $akad->id_cabang;
        $marhunBih->keterangan          = 'AKAD A/N '.$nasabah->nama_lengkap;
        $marhunBih->tanggal_log_kas   = $akad->tanggal_akad;
        $marhunBih->save();

        //'biaya admin'
        $biayaAdmin = new Log_kas_cabang;
        $biayaAdmin->jenis               = 'debit';
        $biayaAdmin->jumlah              = $akad->biaya_admin;
        $biayaAdmin->id_cabang           = $akad->id_cabang;
        $biayaAdmin->keterangan          = 'B.ADM AKAD A/N '.$nasabah->nama_lengkap;
        $biayaAdmin->tanggal_log_kas   = $akad->tanggal_akad;
        $biayaAdmin->save();
    }

}
