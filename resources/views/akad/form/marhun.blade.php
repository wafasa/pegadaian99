<div class="row">
        <div class="col-sm-12">
             <div class="card">
                <div class="card-block">
                    <h3 class="sub-title">Keterangan Marhun Barang Jaminan</h3>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="nama_barang">Nama Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama_barang" id="nama_barang" value="{{old('nama_barang')}}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" >Jenis Barang</label>
                        <div class="col-sm-10">
                            <div class="form-radio">
                                <div class="radio radio-inline">
                                    <label>
                                        <input type="radio" name="jenis_barang" onClick="itemType('elektronik')" value="elektronik" {{checked('elektronik', 'jenis_barang', 'elektronik')}}>
                                        <i class="helper"></i>Elektronik
                                    </label>
                                </div>
                                <div class="radio radio-inline">
                                    <label>
                                        <input type="radio" name="jenis_barang" onClick="itemType('kendaraan')" value="kendaraan" {{checked('kendaran', 'jenis_barang', 'elektronik')}}>
                                        <i class="helper"></i>Kendaraan
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" id="item_elektronik" style="display:none">
                        <label class="col-sm-2 col-form-label" for="type">Type</label>
                        <div class="col-sm-12 col-md-2">
                            <input type="text" class="form-control" name="type" id="type" value="{{old('type')}}">
                        </div>
                        <label class="col-sm-1 col-form-label" for="merk">Merk</label>
                        <div class="col-sm-12 col-md-2">
                            <input type="text" class="form-control" name="merk" id="merk" value="{{old('merk')}}">
                        </div>
                        <label class="col-sm-2 col-form-label" for="no_serial">Imei / Nomor Serial</label>
                        <div class="col-sm-12 col-md-3">
                            <input type="text" class="form-control" name="no_serial" id="no_serial" value="{{old('no_serial')}}">
                        </div>
                    </div>
                    <div class="form-group row" id="item_kendaraan" style="display:">
                        <label class="col-sm-2 col-form-label" for="kt">KT</label>
                        <div class="col-sm-12 col-md-2">
                            <input type="text" class="form-control" name="kt" id="kt" value="{{old('kt')}}">
                        </div>
                        <label class="col-sm-1 col-form-label" for="warna">warna</label>
                        <div class="col-sm-12 col-md-2">
                            <input type="text" class="form-control" name="warna" id="warna" value="{{old('warna')}}">
                        </div>
                        <label class="col-sm-2 col-form-label" for="no_rangka">Nomor Rangka</label>
                        <div class="col-sm-12 col-md-3">
                            <input type="text" class="form-control" name="no_rangka" id="no_rangka" value="{{old('no_rangka')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" >Kelengkapan barang</label>
                        <div class="col-sm-10">
                            <textarea rows="5" cols="5" class="form-control" id="kelengkapan" name="kelengkapan" required>{{old('kelengkapan')}}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" >Kekurangan / Kerusakan Barang</label>
                        <div class="col-sm-10">
                            <textarea rows="5" cols="5" class="form-control" id="kekurangan" name="kekurangan" required>{{old('kekurangan')}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
             <div class="card">
                <div class="card-block">
                    {{-- <h3 class="sub-title">Keterangan Marhun Barang Jaminan</h3> --}}
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="taksiran_marhun">Taksiran Marhun</label>
                        <div class="col-sm-8 col-lg-10">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Rp.</span>
                                <input type="text" class="form-control autonumber" data-v-min="0" data-v-max="9999999999" data-a-sep="." data-a-dec="," name="taksiran_marhun" id="taksiran_marhun" value="{{old('taksiran_marhun')}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="marhun_bih">Marhun Bih</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Rp.</span>
                                <input type="text" class="form-control autonumber"  data-v-min="0" data-v-max="9999999999" data-a-sep="." data-a-dec="," id="marhun_bih" name="marhun_bih" value="{{old('marhun_bih')}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-xs-2 col-form-label" for="persenan">Persenan</label>
                        <div class="col-sm-2 col-xs-2">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">%</span>
                                <input type="text" class="form-control autonumber"  data-v-min="0" data-v-max="9999999999" data-a-sep="." data-a-dec="," id="persenan" disabled>
                                <input type="hidden" name="persenan">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" >Opsi Pembayaran</label>
                        <div class="col-sm-10">
                            <div class="form-radio">
                                @foreach($listTime as $index => $item)
                                    <div class="radio radio-inline" id="op_{{$item['value']}}">
                                        <label>
                                            <input type="radio" name="opsi_pembayaran"  value="{{$item['value']}}" {{checked($item['value'], 'opsi_pembayaran', 1)}}>
                                            <i class="helper"></i>{{$item['text']}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="bt_7_hari">Biaya Titip Per 7 Hari</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{old('bt_7_hari', number_format(10000))}}"  disabled>
                            <input type="hidden" class="form-control" name="bt_7_hari" id="bt_7_hari" value="{{old('bt_7_hari', 10000)}}" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="biaya_admin">Biaya Administrasi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="biaya_admin" value="{{old('biaya_admin', number_format(10000))}}" disabled>
                            <input type="hidden" class="form-control" name="biaya_admin" id="biaya_admin" value="{{old('biaya_admin', 10000)}}" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="terbilang">Terbilang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="terbilang" value="{{old('terbilang')}}" disabled>
                            <input type="hidden" class="form-control" name="terbilang" id="terbilang2" value="{{old('terbilang')}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>