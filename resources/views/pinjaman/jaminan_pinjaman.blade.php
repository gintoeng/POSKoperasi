<fieldset class="hide" id="jamin">
    <form role="form" class="form-horizontal" method="post" action="{!! url('pinjaman/jaminan/post') !!}" enctype="multipart/form-data" id="fjam">
        <input type="hidden" id="pinid" name="pinid" value="null">
        <input type="hidden" id="pid" name="pid" value="tos">
        <legend><h3 id="ttt">Tambah</h3></legend>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nomor_pinjaman_jamin" class="col-sm-3 control-label">Nomor Pinjaman</label>
                    <div class="col-sm-9">
                        <input name="nomor_pinjaman_jamin" type="text" class="form-control" id="nomor_pinjaman_jamin" placeholder="Nomor Pinjaman" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="jenis_jaminan" class="col-sm-3 control-label">Jenis</label>
                    <div class="col-sm-9">
                        <select name="jenis_jaminan" type="text" class="form-control" id="jenis_jaminan" placeholder="Jenis" style="width: 100%">
                            @foreach($jenis as $tampil)
                                <option value="{!! $tampil->id !!}">{!! $tampil->jenis !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="ikatan hukum" class="col-sm-3 control-label">Ikatan Hukum</label>
                    <div class="col-sm-9">
                        <select name="ikatan_hukum" type="text" class="form-control" id="ikatan_hukum" placeholder="Ikatan Hukum" style="width: 100%">
                            <option value="simpanan">Simpanan</option>
                            <option value="apht">apht</option>
                            <option value="skmht">skmht</option>
                            <option value="fiducia">fiducia</option>
                            <option value="kuasa">Surat Kuasa Menjual</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="nama_pemilik" class="col-sm-3 control-label">Nama Pemilik</label>
                    <div class="col-sm-9">
                        <input name="nama_pemilik" type="text" class="form-control" id="nama_pemilik" placeholder="Nama Pemilik">
                    </div>
                </div>
                <div class="form-group">
                    <label for="alamat_pemilik" class="col-sm-3 control-label">Alamat Pemilik</label>
                    <div class="col-sm-9">
                        <input name="alamat_pemilik" type="text" class="form-control" id="alamat_pemilik" placeholder="Alamat Pemilik">
                    </div>
                </div>
                <fieldset id="jsimpanan">
                    <div class="form-group">
                        <label for="nosimpanan" class="col-sm-3 control-label">No Simpanan</label>
                        <div class="col-sm-9">
                            <input name="nomor_simpanan" type="text" class="form-control" id="nosimpanan" placeholder="Nomor Simpanan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bank" class="col-sm-3 control-label">Bank</label>
                        <div class="col-sm-9">
                            <input name="bank" type="text" class="form-control" id="bank" placeholder="Bank">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jumlah" class="col-sm-3 control-label">Jumlah</label>
                        <div class="col-sm-9">
                            <div class="spinner input-group">
                                <input name="jumlah" type="text" class="form-control input-sm spinner-input" id="jumlah" placeholder="Jumlah" value="0">
                                <div class="spinner-buttons input-group-btn">
                                    <button type="button" class="btn btn-warning btn-sm spinner-down">
                                        <i class="ti-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm spinner-up">
                                        <i class="ti-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset id="jemas" class="hide">
                    <div class="form-group">
                        <label for="nosertifikatemas" class="col-sm-3 control-label">No Sertifikat</label>
                        <div class="col-sm-9">
                            <input name="nomor_sertifikat_emas" type="text" class="form-control" id="nosertifikatemas" placeholder="Nomor Sertifikat">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="berat" class="col-sm-3 control-label">Berat</label>
                        <div class="col-sm-9">
                            <div class="spinner input-group">
                                <input name="berat" type="text" class="form-control input-sm spinner-input" id="berat" placeholder="Berat" value="0">
                                <span class="input-group-addon">Gram</span>
                                <div class="spinner-buttons input-group-btn">
                                    <button type="button" class="btn btn-warning btn-sm spinner-down">
                                        <i class="ti-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm spinner-up">
                                        <i class="ti-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="karat" class="col-sm-3 control-label">Karat</label>
                        <div class="col-sm-9">
                            <div class="spinner input-group">
                                <input name="karat" type="text" class="form-control input-sm spinner-input" id="karat" placeholder="Karat" value="0">
                                <div class="spinner-buttons input-group-btn">
                                    <button type="button" class="btn btn-warning btn-sm spinner-down">
                                        <i class="ti-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm spinner-up">
                                        <i class="ti-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset id="jelektronik" class="hide">
                    <div class="form-group">
                        <label for="noserial" class="col-sm-3 control-label">No Serial</label>
                        <div class="col-sm-9">
                            <input name="nomor_serial" type="text" class="form-control" id="noserial" placeholder="No Serial">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tipee" class="col-sm-3 control-label">Tipe</label>
                        <div class="col-sm-9">
                            <input name="tipee" type="text" class="form-control" id="tipee" placeholder="Tipe">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mereke" class="col-sm-3 control-label">Merek</label>
                        <div class="col-sm-9">
                            <input name="mereke" type="text" class="form-control" id="mereke" placeholder="Merek">
                        </div>
                    </div>
                </fieldset>
                <fieldset id="jbangunan" class="hide">
                    <div class="form-group">
                        <label for="nosertifikattanah" class="col-sm-3 control-label">No Sertifikat</label>
                        <div class="col-sm-9">
                            <input name="nomor_sertifikat_tanah" type="text" class="form-control" id="nosertifikattanah" placeholder="Nomor Sertifikat">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kelurahan" class="col-sm-3 control-label">Desa / Kel</label>
                        <div class="col-sm-9">
                            <input name="kelurahan" type="text" class="form-control" id="kelurahan" placeholder="Kelurahan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kecamatan" class="col-sm-3 control-label">Kecamatan</label>
                        <div class="col-sm-9">
                            <input name="kecamatan" type="text" class="form-control" id="kecamatan" placeholder="Kecamatan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kota" class="col-sm-3 control-label">Kota</label>
                        <div class="col-sm-9">
                            <input name="kota" type="text" class="form-control" id="kota" placeholder="Kota">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="provinsi" class="col-sm-3 control-label">Provinsi</label>
                        <div class="col-sm-9">
                            <input name="provinsi" type="text" class="form-control" id="provinsi" placeholder="Provinsi">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nib" class="col-sm-3 control-label">NIB</label>
                        <div class="col-sm-9">
                            <input name="nib" type="text" class="form-control" id="nib" placeholder="NIB">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="peruntukan" class="col-sm-3 control-label">Peruntukan</label>
                        <div class="col-sm-9">
                            <input name="peruntukan" type="text" class="form-control" id="peruntukan" placeholder="Peruntukan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="serhak" class="col-sm-3 control-label">Ser Hak</label>
                        <div class="col-sm-9">
                            <input name="ser_hak" type="text" class="form-control" id="serhak" placeholder="Ser Hak">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="luastanah" class="col-sm-3 control-label">Luas Tanah</label>
                        <div class="col-sm-9">
                            <input name="luas_tanah" type="text" class="form-control" id="luastanah" placeholder="Luas Tanah">
                        </div>
                    </div>
                </fieldset>
                <fieldset id="jkendaraan" class="hide">
                    <div class="form-group">
                        <label for="noplat" class="col-sm-3 control-label">No Plat</label>
                        <div class="col-sm-9">
                            <input name="nomor_plat" type="text" class="form-control" id="noplat" placeholder="No Plat">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nobpkb" class="col-sm-3 control-label">No BPKB</label>
                        <div class="col-sm-9">
                            <input name="nomor_bpkb" type="text" class="form-control" id="nobpkb" placeholder="No BPKB">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="merekk" class="col-sm-3 control-label">Merek</label>
                        <div class="col-sm-4">
                            <input name="merekk" type="text" class="form-control" id="merekk" placeholder="Merek">
                        </div>
                        <label for="tipek" class="col-sm-1 control-label">Tipe</label>
                        <div class="col-sm-4">
                            <input name="tipek" type="text" class="form-control" id="tipek" placeholder="Tipe">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jenis" class="col-sm-3 control-label">Jenis</label>
                        <div class="col-sm-4">
                            <input name="jenis" type="text" class="form-control" id="jenis" placeholder="Jenis">
                        </div>
                        <label for="model" class="col-sm-1 control-label">Model</label>
                        <div class="col-sm-4">
                            <input name="model" type="text" class="form-control" id="model" placeholder="Model">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tahun" class="col-sm-3 control-label">Tahun</label>
                        <div class="col-sm-4">
                            <input name="tahun" type="text" class="form-control" id="tahun" placeholder="Tahun">
                        </div>
                        <label for="cc" class="col-sm-1 control-label">CC</label>
                        <div class="col-sm-4">
                            <input name="cc" type="text" class="form-control" id="cc" placeholder="CC">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="warna" class="col-sm-3 control-label">Warna</label>
                        <div class="col-sm-4">
                            <input name="warna" type="text" class="form-control" id="warna" placeholder="Warna">
                        </div>
                        <label for="jmlroda" class="col-sm-1 control-label">Jml Roda</label>
                        <div class="col-sm-4">
                            <input name="jml_roda" type="text" class="form-control" id="jmlroda" placeholder="Jml Roda">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="norangka" class="col-sm-3 control-label">No Rangka</label>
                        <div class="col-sm-4">
                            <input name="nomor_rangka" type="text" class="form-control" id="norangka" placeholder="No Rangka">
                        </div>
                        <label for="nomesin" class="col-sm-1 control-label">No Mesin</label>
                        <div class="col-sm-4">
                            <input name="nomor_mesin" type="text" class="form-control" id="nomesin" placeholder="Nomor Mesin">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bahanbakar" class="col-sm-3 control-label">Bahan Bakar</label>
                        <div class="col-sm-4">
                            <input name="bahan_bakar" type="text" class="form-control" id="bahanbakar" placeholder="Bahan Bakar">
                        </div>
                    </div>
                </fieldset>
                <fieldset id="jtanpa" class="hide">
                    <div class="form-group">
                        <label for="nom" class="col-sm-3 control-label">No.</label>
                        <div class="col-sm-9">
                            <input name="nomor" type="text" class="form-control" id="nom" placeholder="Nomor">
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="foto" class="col-sm-3 control-label">Foto</label>
                    <div class="col-sm-3" id="ft">
                        <img id="imgfoto" src="{{asset('assets/img/avatar.jpg')}}" alt="your image" width="100" />
                        <input name="foto" type="file" id="foto" placeholder="Foto">
                        <input name="fot" type="hidden" id="fot" placeholder="Foto" value="">
                    </div>
                    <label for="foto2" class="col-sm-2 control-label">Foto2</label>
                    <div class="col-sm-3" id="ft2">
                        <img id="imgfoto2" src="{{asset('assets/img/avatar.jpg')}}" alt="your image" width="100" />
                        <input name="foto2" type="file" id="foto2" placeholder="Foto">
                        <input name="fot2" type="hidden" id="fot2" placeholder="Foto" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="nilai" class="col-sm-3 control-label">Nilai</label>
                    <div class="col-sm-9">
                        <input name="nilai" type="text" class="form-control" id="nilai" placeholder="0.00" value="0.00" style="text-align: right">
                    </div>
                </div>
                <div class="form-group">
                    <label for="nomor_arsip" class="col-sm-3 control-label">Nomor Arsip</label>
                    <div class="col-sm-9">
                        <input name="nomor_arsip" type="text" class="form-control" id="nomor_arsip" placeholder="Nomor Arsip">
                    </div>
                </div>
                <div class="form-group">
                    <label for="keterangan_jamin" class="col-sm-3 control-label">Keterangan</label>
                    <div class="col-sm-9">
                        <input name="keterangan_jamin" type="text" class="form-control" id="keterangan_jamin" placeholder="Keterangan">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <label for="save" class="col-sm-3 control-label"></label>
                    <div class="col-sm-2">
                        <a id="subbb" class="btn btn-primary btn-block">Save</a>
                    </div>
                    <div class="col-sm-2">
                        <a id="sub" class="btn btn-danger btn-block">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</fieldset>
