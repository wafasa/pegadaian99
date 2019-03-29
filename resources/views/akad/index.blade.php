@extends('_layouts.default')

@section('script-bottom')

@endsection

@section('script-top')
    <style>
    
    </style>
@endsection

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4 class="">Data Akad</h4>
                    {{-- <span>Rincian Dana</span> --}}
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            {{-- <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.html"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Form Picker</a></li>
                </ul>
            </div> --}}
        </div>
    </div>
</div>
<div class="page-body">
    <div class="row">
        <div class="col-sm-6 col-md-12">
             <div class="card">
                <div class="card-header">
                    
                </div>
                <div class="card-block">
                    <!-- Row start -->
                    <div class="row">
                        <div class="col-lg-12 col-xl-12">
                            {{-- <div class="sub-title">List Nasabah Akad</div> --}}
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs md-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#home3" role="tab">Nasabah akad</a>
                                    <div class="slide"></div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#profile3" role="tab">Akad Jatuh Tempo</a>
                                    <div class="slide"></div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#profile3" role="tab">Pelunasan & Lelang</a>
                                    <div class="slide"></div>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content card-block">
                                {{-- <form method="get"> --}}
                                <div class="tab-pane active" id="home3" role="tabpanel">
                                    <div class="sub-title">List Nasabah Akad</div>
                                    <div class="row">
                                        <div class="col-sm-3 col-md-3">
                                            
                                                <div class="form-group">
                                                    <input type="text" name="daterange" id="date" class="form-control" value="{{$dateRange}}" />
                                                </div>
                                        </div>
                                    </div>                             
                                    <div class="row">
                                        <div class="col-sm-12 col-md-2">
                                             <div class="form-group">
                                                {{-- Show &nbsp; --}}
                                                <select name="perpage" id="perpage" class="form-control">
                                                    <option {{ selected(10, 'perpage', 'request')}}>10</option>
                                                    <option {{ selected(25, 'perpage', 'request')}}>25</option>
                                                    <option {{ selected(50, 'perpage', 'request')}}>50</option>
                                                    <option {{ selected(100, 'perpage', 'request')}}>100</option>
                                                </select> 
                                                {{-- &nbsp; Entries --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 offset-md-4">
                                            <div class="row">
                                                <div class="col-sm-4 col-md-4">
                                                    <div class="form-group">
                                                       
                                                        <select name="by" id="by" class="form-control">
                                                            @foreach($selectBy as $index => $item)
                                                                <option value="{{$item}}" {{selected($item, 'by', 'request')}}>{{$item}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5 col-md-5">
                                                    <div class="input-group input-group-success">
                                                        <span class="input-group-addon">
                                                           <i class="icofont icofont-ui-search"></i>
                                                        </span>
                                                        <input type="text" name="q" id="q" value="{{ request('q') }}" class="form-control" placeholder="Search">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 col-md-2">
                                                    <button type="button" class="btn btn-default" id="btn-search">Oke</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="table-responsive dt-responsive">
                                        <table id="dt-ajax-array" class="table table-striped table-bordered nowrap">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>No. telp</th>
                                                <th>ID</th>
                                                <th>Jaminan</th>
                                                <th>Pinjaman</th>
                                                <th>Tunggakan</th>
                                                <th>Tanggal Akad</th>
                                                <th>Jatuh Tempo</th>
                                                <th>Prosedur</th>
                                                {{-- <th>action</th> --}}
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($akad as $index => $item)
                                                    <tr>
                                                        <td>{{$index + 1}}</td>
                                                        <td>{{$item->nama_lengkap}}</td>
                                                        <td>{{$item->no_telp}}</td>
                                                        <td>{{$item->no_id}}</td>
                                                        <td>{{$item->nama_barang}}</td>
                                                        <td>{{$item->nilai_tafsir}}</td>
                                                        <td></td>
                                                        <td>{{$item->tanggal_akad}}</td>
                                                        <td>{{$item->tanggal_jatuh_tempo}}</td>
                                                        <td></td>
                                                        {{-- <td>
                                                            <a href="{{route('akad.edit', $item->id)}}" class="btn btn-sm btn-info">
                                                                <i class="icon-pencil3"></i> Edit
                                                            </a>
                                                            <a href="{{ route('akad.destroy', $item->id)}}"
                                                                data-method="delete" data-confirm="Anda yakin akan menghapus data ini ?"
                                                                class="btn btn-sm btn-danger" title="Hapus Data">
                                                                <i class="icon-trash3"></i>
                                                                Delete
                                                            </a>
                                                        </td> --}}
                                                    </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="11" align="center">No data available in table</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                            {{-- <tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Office</th>
                                                <th>Age</th>
                                                <th>Start date</th>
                                                <th>Salary</th>
                                            </tr>
                                            </tfoot> --}}
                                        </table>
                                    </div>
                                   {!! $akad->appends(Request::input())->render('vendor.pagination.bootstrap-4'); !!}
                                </div>
                            {{-- </form> --}}
                                <div class="tab-pane" id="profile3" role="tabpanel">
                                     
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row end -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
