@extends('_layouts.default')

@section('script-bottom')
    <script>
        function detail(id)
        {
            var url = $('#detail_'+id).attr('data-url')
            // console.log(laravel.csrfToken);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': laravel.csrfToken
                }
            });

            $.ajax({
                url: url,
                method: 'get',
                beforeSend: function(){
                    $('#modal-detail').modal('show')
                    // view css loading show
                    $('#loader-block').css('display', '')
                    $('#data-detail').css('display', 'none')
                },
                success: function(result){
                    // var modal = $('#modal-coba').modal('show')
                    // view css loading hide
                    $('#loader-block').css('display', 'none')
                    $('#data-detail').css('display', '')
                    show_data(result)
                }
            });
        }

        function show_data(data)
        {
            var rowsOne = '';
            var rowsTwo = '';
            rowsOne = rowsOne + '<tr>';
                rowsOne = rowsOne + '<td>Nama</td>';
                rowsOne = rowsOne + '<td>'+data.nama_lengkap+'</td>';
            rowsOne = rowsOne + '</tr>';
            rowsOne = rowsOne + '<tr>';
                rowsOne = rowsOne + '<td>Jenis Kelamin</td>';
                rowsOne = rowsOne + '<td>'+data.jenis_kelamin+'</td>';
            rowsOne = rowsOne + '</tr>';
            rowsOne = rowsOne + '<tr>';
                rowsOne = rowsOne + '<td>Kota</td>';
                rowsOne = rowsOne + '<td>'+data.kota+'</td>';
            rowsOne = rowsOne + '</tr>';
            rowsOne = rowsOne + '<tr>';
                rowsOne = rowsOne + '<td>No. Telp</td>';
                rowsOne = rowsOne + '<td>'+data.no_telp+'</td>';
            rowsOne = rowsOne + '</tr>';
            rowsOne = rowsOne + '<tr>';
                rowsOne = rowsOne + '<td>Alamat</td>';
                rowsOne = rowsOne + '<td>'+data.alamat+'</td>';
            rowsOne = rowsOne + '</tr>';

            rowsTwo = rowsTwo + '<tr>';
                rowsTwo = rowsTwo + '<td>Jenis ID</td>';
                rowsTwo = rowsTwo + '<td>'+data.jenis_id+'</td>';
            rowsTwo = rowsTwo + '</tr>';
            rowsTwo = rowsTwo + '<tr>';
                rowsTwo = rowsTwo + '<td>No Identitas</td>';
                rowsTwo = rowsTwo + '<td>'+data.no_identitas+'</td>';
            rowsTwo = rowsTwo + '</tr>';
            rowsTwo = rowsTwo + '<tr>';
                rowsTwo = rowsTwo + '<td>Tanggal Lahir</td>';
                rowsTwo = rowsTwo + '<td>'+data.tanggal_lahir+'</td>';
            rowsTwo = rowsTwo + '</tr>';
            rowsTwo = rowsTwo + '<tr>';
                rowsTwo = rowsTwo + '<td>Tanggal Daftar</td>';
                rowsTwo = rowsTwo + '<td>'+data.tanggal_daftar+'</td>';
            rowsTwo = rowsTwo + '</tr>';

            $("#table-detail-one").html(rowsOne);
            $("#table-detail-two").html(rowsTwo);
        }                

        $(function(){
            $('#perpage').change(function(){
                // this.form.submit()
            });
        });
    </script>
@endsection

@section('content')
@include('nasabah.modal')
<div class="page-header">
    <div class="row">
        <div class="col-md-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Data Nasabah</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
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
        <div class="col-sm-12 col-md-12">
             {!! session()->get('message') !!}
        </div>
    </div>
     <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="sub-title">Data Table Nasabah</div>
                </div>
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
                                @foreach($column as $index => $item)
                                    <th>{{$item}}</th>
                                @endforeach
                                {{-- <th>action</th> --}}
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($nasabah as $index => $item)
                                    <tr>
                                        <td>{{$item->nama_lengkap}}</td>
                                        <td>{{$item->no_telp}}</td>
                                        <td>{{$item->alamat}}</td>
                                        <td align="center">
                                            <a href="javascript:void(0)" onClick="detail({{$item->id_nasabah}})" title="Detail Data"
                                               data-url="{{route('nasabah.detail', $item->id_nasabah)}}" id="detail_{{$item->id_nasabah}}" class="btn btn-sm btn-info">
                                                <i class="icofont icofont-external icofont-lg"></i>
                                            </a>
                                            <a href="{{route('nasabah.edit', $item->id_nasabah)}}" class="btn btn-sm btn-primary" title="Edit Data">
                                                {{-- <i class="icofont icofont-ui-delete icofont-lg"></i> --}}
                                                <i class="icofont icofont-edit icofont-lg"></i>
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
                   {!! $nasabah->appends(Request::input())->render('vendor.pagination.bootstrap-4'); !!}                   
                </div>
            </div>
        </div>
    </div>
@endsection