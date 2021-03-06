@extends('_layouts.default')

@section('script-top')
<!-- Range slider css -->
<link rel="stylesheet" type="text/css" href="{{asset('adminty/files/bower_components/seiyria-bootstrap-slider/css/bootstrap-slider.css')}}">

<!-- Date-time picker css -->
<link rel="stylesheet" type="text/css" href="{{asset('adminty/files/assets/pages/advance-elements/css/bootstrap-datetimepicker.css')}}">

<!-- Date-range picker css  -->
<link rel="stylesheet" type="text/css" href="{{asset('adminty/files/bower_components/bootstrap-daterangepicker/css/daterangepicker.css')}}">
@endsection

@section('script-bottom')
<!-- Bootstrap date-time-picker js -->
<script type="text/javascript" src="{{asset('adminty/files/assets/pages/advance-elements/moment-with-locales.min.js')}}"></script>
<script type="text/javascript" src="{{asset('adminty/files/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('adminty/files/assets/pages/advance-elements/bootstrap-datetimepicker.min.js')}}"></script>
<!-- Date-range picker js -->
<script type="text/javascript" src="{{asset('adminty/files/bower_components/bootstrap-daterangepicker/js/daterangepicker.js')}}"></script>
<!-- Date-dropper js -->
<script type="text/javascript" src="{{asset('adminty/files/bower_components/datedropper/js/datedropper.min.js')}}"></script>
<!-- Color picker js -->
<script type="text/javascript" src="{{asset('adminty/files/bower_components/spectrum/js/spectrum.js')}}"></script>
<script type="text/javascript" src="{{asset('adminty/files/bower_components/jscolor/js/jscolor.js')}}"></script>

<script type="text/javascript" src="{{asset('adminty/files/assets/pages/advance-elements/custom-picker.js')}}"></script>

<!-- jquery redirect -->
<script type="text/javascript" async src="https://cdn.rawgit.com/mgalante/jquery.redirect/master/jquery.redirect.js"></script>

<script>

    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    $(document).ready(function() {
        $('[data-toggle="popover"]').popover({
            html: true,
            content: function() {
                var content = $(this).attr("data-popover-content");
                return $(content).children(".popover-body").html();
                // return $('#primary-popover-content').html();
            }
        });
    });

    function prosedur(type)
    {
        if(type == 'pelunasan'){
            $('#pelunasan').css('display', '')
        }else{
            $('#pelunasan').css('display', 'none')
        }

        $('#modal-prosedur-na').modal('show');
    }

    function edit(id)
    {
        $('#modal-edit').modal('show');
    }

    function review()
    {
        $('#modal-review-na').modal('show');
        
        // for close popover on button "kwitansi biaya titip"
        $('[data-toggle="popover"]').popover('hide');
    }
</script>
@endsection

@section('content')
{{-- include file modal  --}}
@include('akad.modal.index.prosedur')
@include('akad.modal.index.form')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4 class="">Data Akad Nasabah</h4>
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
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block">
                    <div class="sub-title">
                        <h6>Akad Jatuh Tempo</h6>
                    </div> 
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-3 col-form-label" for="jenis_ajt">Jenis Akad Jatuh Tempo</label>
                        <div class="col-sm-12 col-md-9">
                            <select name="jenis_ajt" id="jenis_ajt" class="form-control form-control-success">
                                @foreach ($nameTables as $index => $item)
                                    <option value="{{$item['key']}}" {{selected($item['key'], 'jenis_ajt', 'request')}}>{{$item['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-xs">Proses</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <form method="get">
                <div class="card-block">
                        <!-- Row start -->
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
                                <div class="col-sm-12 col-md-3 offset-md-1">
                                    <div class="form-group">
                                        <select name="by" id="by" class="form-control">
                                            @foreach($column as $index => $item)
                                                <option value="{{$index}}" {{selected($index, 'by', 'request')}}>{{$item}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-5">
                                    <div class="input-group input-group-success">
                                        <span class="input-group-addon">
                                            <i class="icofont icofont-ui-search"></i>
                                        </span>
                                        <input type="text" name="q" id="q" value="{{ request('q') }}" class="form-control" placeholder="Search">
                                    </div>
                                </div>
                                <div class="col-sm-2 col-md-2">
                                    <button type="submit" class="btn btn-default" id="btn-search">Oke</button>
                                </div>
                            </div>
                        </div>
                    </div><br>
                    </form>
                    <div class="table-responsive dt-responsive">
                        <table id="dt-ajax-array" class="table table-striped table-bordered nowrap">
                            <thead>
                            <tr>
                                <th>No</th>
                                @foreach($column as $index => $item)
                                    <th>{{$item}}</th>
                                @endforeach
                                <th>Prosedur</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $index => $item)
                                <tr>
                                        <td>{{$index + 1}}</td>
                                        <td>{{$item->nama_lengkap}}</td>
                                        <td>{{$item->no_telp}}</td>
                                        <td>{{$item->no_id}}</td>
                                        <td>{{$item->nama_barang}}</td>
                                        <td>{{$item->nominal_nilai_tafsir}}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{$item->tanggal_akad}}</td>
                                        <td>{{$item->tanggal_jatuh_tempo}}</td>
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-mini btn-primary" onClick="prosedur('bt')">
                                                Bayar B. Titip
                                            </a>
                                            <a href="javascript:void(0)" class="btn btn-mini btn-success" onClick="prosedur('pelunasan')">
                                                Pelunasan
                                            </a>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-mini btn-info" onClick="review()">
                                                <i class="zmdi zmdi-search"></i>
                                            </a>
                                            <button 
                                                type="button" 
                                                class="btn btn-success btn-mini waves-effect waves-light" 
                                                data-toggle="popover" 
                                                data-placement="left" 
                                                title="Print Menu"
                                                data-popover-content="#a2">
                                                <i class="zmdi zmdi-print"></i>
                                            </button>
                                            {{-- for menu-mini button print --}}
                                            <div id="a2" style="display:none">
                                                <div class="popover-heading"></div>
                                                <div class="popover-body">
                                                    <a href="javascript:void(0)" class="btn btn-mini btn-success mb-1">
                                                        <i class="zmdi zmdi-print"></i> Surat Akad
                                                    </a>
                                                    <a href="javascript:void(0)" class="btn btn-mini btn-success mb-1">
                                                        <i class="zmdi zmdi-print"></i> Kwitansi Akad
                                                    </a>
                                                    <a href="javascript:void(0)" class="btn btn-mini btn-success" onClick="review()">
                                                        <i class="zmdi zmdi-search"></i> Kwitansi Biaya Titip
                                                    </a>
                                                </div>
                                            </div>
                                            <a href="javascript:void(0)" class="btn btn-mini btn-primary" onClick="edit({{$item->id_akad}})">
                                                <i class="icofont icofont-edit icofont-sm"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                <tr>
                                    <td colspan="11" align="center">No data available in table</td>
                                </tr>
                                @endforelse
                            </tbody>
                            {{-- <tfoot>
                            </tfoot> --}}
                        </table>
                    </div>
                    {!! $data->appends(Request::input())->render('vendor.pagination.bootstrap-4'); !!}                   
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection
