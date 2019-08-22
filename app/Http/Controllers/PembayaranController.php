<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bku;
use App\Models\Akad;
use App\Models\Biaya_titip;
use App\Models\Administrasi;

use Auth;
use Carbon\Carbon;

class PembayaranController extends Controller
{
	public function __construct(
    							Bku $bku,
    							Akad $akad,
                                Request $request,
    							Biaya_titip $biaya_titip,
                                Administrasi $administrasi
                            )
    {
        $this->bku  	    = $bku;
    	$this->akad  	    = $akad;
        $this->request      = $request;
        $this->biaya_titip  = $biaya_titip;
        $this->administrasi = $administrasi;

        view()->share([
            'menu'          => 'pembayaran',
            'subMenu'       => '',
            'menuHeader'    => config('library.menu_header'),
        ]);
    }

    public function pendapatan()
    {
        $biayaTitip    = $this->biaya_titip();
        $administrasi   = $this->administrasi();

        // list column 'list biaya titip' and 'list biaya administrasi'
        $columnBiayaTitip           = config('library.column.pendapatan.list_biaya_titip');
        $columnBiayaAdministrasi    = config('library.column.pendapatan.list_biaya_administrasi');

    	return $this->template('pembayaran.pendapatan', compact(
            'columnBiayaTitip', 'columnBiayaAdministrasi', 
            'administrasi', 'biayaTitip'
        ));
    }

    // for table 'LIST BIAYA TITIP'
    public function biaya_titip()
    {
        $endDate    = Carbon::now();
        $startDate  = Carbon::now()->startOfMonth();

        $akad = $this->akad->joinNasabah()->joinBiayaTitip();
        $akad = $akad->sorted('tanggal_akad', 'desc');
        $akad = $akad->whereBetween('tanggal_akad', [$startDate, $endDate]);
        $akad = $akad->paginate(10);

        return $akad;
    }

    // for table 'LIST BIAYA ADMINISTRASI'
    public function administrasi()
    {
        $akad = $this->akad->joinNasabah()->baseBranch();
        $akad = $akad->sorted('tanggal_akad', 'desc');
        $akad = $akad->paginate(10);

        return $akad;
    }

    public function bku()
    {
        $bku = $this->bku->baseBranch()->jenis('kas')->sorted();

        if(request('by')){
            $bku = $bku->search(request('by'), request('q'));
        }

        $bku = $bku->paginate(request('perpage', 10));

        $column = config('library.column.bku');

    	return $this->template('pembayaran.bku', compact(
            'column', 'bku'
        ));
    }
}
