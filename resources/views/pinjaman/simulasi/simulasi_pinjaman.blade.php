
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="mtestt" class="modal-title">Pinjaman</h4>
            </div>
            <div class="modal-body">
                <p id="mtest">Apakah anda ingin menambahkan jaminan ?</p>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-2 pull-left">
                        <button type="button" id="btnselesai" class="btn btn-success" data-dismiss="modal">Selesai</button>
                    </div>
                    <div class="col-md-10 pull-right">
                        <button type="button" id="btnlanjut" class="btn btn-primary" data-dismiss="modal">Lanjutkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="reModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="mtesttx" class="modal-title">Pilih Nama pinjaman</h4>
            </div>
            <div class="modal-body">
                <p id="mtestx">Pilih Nama pinjaman terlebih dahulu untuk melihat simulasi.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="simulasiModal" tabindex="-1" role="dialog" aria-labelledby="simulasiModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Simulasi Pembayaran</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <input type="hidden" name="id_simulasi" id="id_simulasi">
                        <div class="form-group" style="margin-bottom:50px">
                            <label for="nama_simulasi" class="col-sm-2 control-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" name="nama" class="form-control" id="nama_simulasi" readonly>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom:50px">
                            <label for="sistem_bungasim" class="col-sm-2 control-label">Sistem Bunga</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="sistem_bungasim" id="sistem_bungasim" readonly>
                            </div>
                        </div>
                        {{--<div class="form-group">--}}
                            {{--<label for="sistem_bungasim" class="col-sm-2 control-label">Sistem Bunga</label>--}}
                            {{--<div class="col-sm-10">--}}
                                {{--<select class="form-control" name="sistem_bungasim" id="sistem_bungasim" style="width: 100%" readonly>--}}
                                    {{--<option value="">Pilih Sistem Bunga</option>--}}
                                    {{--@foreach($sistem_bunga as $value)--}}
                                        {{--<option value="{{ $value->id }}" >{{ $value->sistem }}</option>--}}
                                    {{--@endforeach--}}
                                {{--</select>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="row">
                            <div class="col-xs-4 col-sm-6">
                                <div class="form-group" style="margin-top:15px">
                                    <label for="bunga_simulasi" class="col-sm-5 control-label">Suku Bunga</label>
                                    <div class="input-group">
                                        <input name="suku_bunga" type="text" class="form-control right" id="bunga_simulasi" style="text-align:right" readonly="">
                                        <span class="input-group-addon">% PA</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jangkawaktu_simulasi" class="col-sm-5 control-label">Jangka Waktu</label>
                                    <div class="input-group">
                                        <input name="jangka_waktu" type="text" class="form-control right" id="jangkawaktu_simulasi" style="text-align:right" readonly="">
                                        <span class="input-group-addon">BULAN</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jmlpengajuan_simulasi" class="col-sm-4 control-label">Jml Pengajuan</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="jumlah_pengajuan" class="form-control" id="jmlpengajuan_simulasi" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-6">
                                <div class="form-group" style="margin-top:15px">
                                    <label for="tgl_pengajuan" class="col-sm-4 control-label">Tgl Pengajuan</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="tgl_pengajuan" class="form-control" id="tgl_pengajuan" readonly>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top:65px">
                                    <label for="jth_tempo" class="col-sm-4 control-label">Jatuh Tempo</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="jatuh_tempo" class="form-control" id="jth_tempo" readonly>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top:115px">
                                    <label for="angsuran_simulasi" class="col-sm-4 control-label">Angsuran</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="angsuran_simulasi" class="form-control" id="angsuran_simulasi" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:20px">
                    <div class="col-md-12">
                        <div class="table-responsive no-border" id="table-simulasi">
                            <table class="table table-bordered table-striped no-m">
                                <thead>
                                <tr class="bg-color">
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Saldo</th>
                                    <th class="text-center">Pokok</th>
                                    <th class="text-center">Bunga</th>
                                    <th class="text-center">Angsuran</th>
                                </tr>
                                </thead>
                                <tbody id="bodybunga">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
