<div class="row">
        <div class="col-sm-12">
             <div class="card">
                <div class="card-block">
                    <h3 class="sub-title">Data Rahin</h3>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="nama_lengkap">Nama Lengkap</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" value="{{old('nama_lengkap')}}" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" >Jenis Kelamin</label>
                        <div class="col-sm-10">
                            <div class="form-radio">
                                <div class="radio radio-inline">
                                    <label>
                                        <input type="radio" name="jenis_kelamin" value="pria" {{checked('pria', 'jenis_kelamin', 'pria')}}>
                                        <i class="helper"></i>Pria
                                    </label>
                                </div>
                                <div class="radio radio-inline">
                                    <label>
                                        <input type="radio" name="jenis_kelamin" value="wanita" {{checked('wanita', 'jenis_kelamin', 'pria')}}>
                                        <i class="helper"></i>Wanita
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" >Alamat</label>
                        <div class="col-sm-10">
                            <textarea rows="5" cols="5" class="form-control" id="alamat" name="alamat" >{{old('alamat')}}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="kota">Kota</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="kota" id="kota" value="{{old('kota')}}" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="no_telp">No. Telp</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="no_telp" id="no_telp" value="{{old('no_telp')}}" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" >Jenis Identitas</label>
                        <div class="col-sm-10">
                            <div class="form-radio">
                                <div class="radio radio-inline">
                                    <label>
                                        <input type="radio" name="jenis_id" value="KTP" {{checked('KTP', 'jenis_id', 'KTP')}}>
                                        <i class="helper"></i>KTP
                                    </label>
                                </div>
                                <div class="radio radio-inline">
                                    <label>
                                        <input type="radio" name="jenis_id" value="SIM" {{checked('SIM', 'jenis_id', 'KTP')}}>
                                        <i class="helper"></i>SIM
                                    </label>
                                </div>
                                <div class="radio radio-inline">
                                    <label>
                                        <input type="radio" name="jenis_id" value="KK" {{checked('KK', 'jenis_id', 'KTP')}}>
                                        <i class="helper"></i>KK
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="no_identitas">No. Identitas</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="no_identitas" id="no_identitas" value="{{old('no_identitas')}}" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="tanggal_lahir">Tanggal Lahir</label>
                        <div class="col-sm-3">
                            <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="{{old('tanggal_lahir', '2000-01-01')}}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-xs">Proses</button>
                </div>
            </div>
        </div>
    </div>