<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Nasabah;

class NasabahController extends Controller
{
    public function __construct(
                                Nasabah $nasabah,
                                Request $request
                               )
    {
        $this->nasabah          = $nasabah;
        $this->request          = $request;

        view()->share([
            'menu'          => 'nasabah',
            'menu_header'   => config('library.menu_header'),
        ]);
    }

    public function index()
    {
        $nasabah 	= $this->nasabah->sorted()->paginate(5);
        $column		= config('library.column.nasabah');

    	return view('nasabah.index', compact('nasabah', 'column'));
    }
}
