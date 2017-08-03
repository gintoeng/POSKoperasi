@extends('layouts.master')

@section('content')

    <style>
        #table-wrapper {
            position:relative;
        }
        #table-scroll {
            height:750px;
            overflow:auto;
            margin-top:20px;
        }
        #table-wrapper table {
            width:100%;

        }
        #table-wrapper table thead th .text {
            position:absolute;
            top:-20px;
            z-index:2;
            height:20px;
            width:35%;
            border:1px solid red;
        }
    </style>

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Simpanan</a>
        </li>
        <li class="active">Proses Simpanan</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    @if(session('alert'))
                        <br/><br/>
                        {!! session('alert') !!}
                    @endif
                    <input type="hidden" value="{!! $mod !!}" id="mod">
                    <form method="post" action="{!! url('simpanan/proses') !!}" id="fpro">
                        <section class="panel">
                            <!-- <header class="panel-heading">Test Panel</header>-->
                            <div class="panel-body">
                                <center><font size="5">PROSES SIMPANAN</font></center>
                                <br><br>
                                <div class="alert alert-info">
                                    <br>
                                    <p>Proses Simpanan berfungsi untuk memproses : </p>
                                    <br>
                                    <p>Bunga Simpanan, Pajak Bunga Simpanan, dan Administrasi Simpanan.Proses ini dapat dilakukan sebulan sekali</p>
                                    <p>Apabila ingin diulangi maka anda dapat melakukan Proses ini kembali.</p>
                                    <br>
                                    <p>Proses Simpanan ini akan tercatat pada tanggal terakhir pada bulan yang diproses.</p>
                                    <br>
                                </div>
                                    <div class="form-group">
                                        <div  class="col-sm-2"></div>
                                        <div class="col-sm-4">
                                            <select name="bulan" type="text" class="form-control chosen" id="bulan" placeholder="Bulan" style="width: 100%" required>
                                                <option value="01" {!! $bln == "01" ? 'selected' : '' !!}>Januari</option>
                                                <option value="02" {!! $bln == "02" ? 'selected' : '' !!}>Februari</option>
                                                <option value="03" {!! $bln == "03" ? 'selected' : '' !!}>Maret</option>
                                                <option value="04" {!! $bln == "04" ? 'selected' : '' !!}>April</option>
                                                <option value="05" {!! $bln == "05" ? 'selected' : '' !!}>Mei</option>
                                                <option value="06" {!! $bln == "06" ? 'selected' : '' !!}>Juni</option>
                                                <option value="07" {!! $bln == "07" ? 'selected' : '' !!}>Juli</option>
                                                <option value="08" {!! $bln == "08" ? 'selected' : '' !!}>Agustus</option>
                                                <option value="09" {!! $bln == "09" ? 'selected' : '' !!}>September</option>
                                                <option value="10" {!! $bln == "10" ? 'selected' : '' !!}>Oktober</option>
                                                <option value="11" {!! $bln == "11" ? 'selected' : '' !!}>November</option>
                                                <option value="12" {!! $bln == "12" ? 'selected' : '' !!}>Desember</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="spinner input-group">
                                                <input name="tahun" type="text" class="form-control input-sm spinner-input" id="tahun" placeholder="Tahun" value="{!! $th !!}" required>
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
                                        <div class="col-sm-2"></div>
                                    </div>
                                    <br><br><br><br>
                                    <div class="form-group">
                                        <div class="col-sm-3"></div>
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <div class="col-sm-6">
                                            <button id="btnsub" type="button" class="btn btn-primary btn-block btn-lg"><font size="3"><i class="fa fa-gear"> Proses Data</i></font></button>
                                        </div>
                                        <div class="col-sm-3"></div>
                                    </div>
                                    <br><br>
                                    {{--<div class="progress progress-lg progress-striped active">--}}
                                        {{--<div id="bar" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"><span class="sr-only">40% Complete (success)</span></div>--}}
                                    {{--</div>--}}
                                {{--<div class="col-md-2">--}}
                                    {{--<input type="checkbox" name="progress" class="progress" value="0">--}}
                                {{--</div>--}}
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-sm-2 pull-left">
                                        <a href="javascript:void(0)" id="btnlihat" class="btn btn-success btn-block">Lihat</a>
                                    </div>
                                    <div class="col-lg-8"></div>
                                    <div class="col-sm-2 pull-right">
                                        <a href="{!! url('/') !!}" id="cancel" class="btn btn-danger btn-block">Cancel</a>
                                            {{--<input type="checkbox" id="minimal-checkbox-1" name="auto" value="auto">--}}
                                            {{--<label for="minimal-checkbox-1"> AUTODEBET</label>--}}

                                    </div>
                                </div>
                            </div>
                        </section>
                    </form>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>

    <div class="modal fade" id="rejectModal2" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="judul">PROSES SIMPANAN</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_simulasi" class="col-sm-4 control-label">Proses :</label>
                                <div class="col-sm-8">
                                    <label for="nama_simulasi" class="col-sm-2 control-label">SIMPANAN</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-12 control-label text-right">{{$tgl}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="table-wrapper">
                            <div class="table-responsive no-border" id="table-scroll">
                                <table id="tabproc" class="table table-bordered table-striped no-m scroll" >
                                    <thead>
                                    <tr class="bg-color" style="width: 100%; display: inline-table;table-layout: fixed;">
                                        <th class="text-center" width="50">No.</th>
                                        <th class="text-center">Simpanan</th>
                                        {{--<th class="text-center">Nama</th>--}}
                                        <th class="text-center">Bunga</th>
                                        <th class="text-center">Pajak</th>
                                        <th class="text-center">Adm</th>
                                        <th class="text-center">Diterima</th>
                                    </tr>
                                    </thead>
                                    <tbody id="bodyproc" style="overflow-y: scroll;height: 700px;width: auto;position: absolute;">
                                    <?php $i = 1; ?>
                                    @foreach($proc as $tampil)
                                        <tr style="width: 100%;display: inline-table;table-layout: fixed;">
                                            <td class="text-center" width="50">{!! $i++ !!}</td>
                                            <td>{!! $tampil->simpananid->nomor_simpanan !!}</td>
                                            {{--<td>{!! $tampil->simpananid->anggotaid->nama !!}</td>--}}
                                            <td class="text-right">{!! number_format($tampil->bunga, 2, '.', ',') !!}</td>
                                            <td class="text-right">{!! number_format($tampil->pajak, 2, '.', ',') !!}</td>
                                            <td class="text-right">{!! number_format($tampil->simpananid->pengaturanid->administrasi, 2, '.', ',') !!}</td>
                                            <td class="text-right">{!! number_format($tampil->diterima, 2, '.', ',') !!}</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-2 pull-left">
                        <button type="button" onclick="cetak('proc')" id="btncetakproc" class="btn btn-success"><i class="ti-printer"> Cetak</i></button>
                    </div>
                    <div class="col-md-10 pull-right">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
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
                    <h4 class="modal-title" id="judul">Proses Simpanan</h4>
                </div>
                <div class="modal-body">
                    <p id="mess">Pilih nomor pinjaman terlebih dahulu untuk melihat simulasi.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#btnlihat').on('click', function() {
            $('#tabproc').load("{!! url('simpanan/proses/show') !!}/" + $('#bulan').val() + "/" + $('#tahun').val());
            $("#rejectModal2").modal();
        });

        function cetak(cce) {
            window.open("{!! url('simpanan/proses/cetak') !!}/" + $('#bulan').val() + "/" + $('#tahun').val());
        }

        if($('#mod').val() == "modd") {
            $("#rejectModal2").modal();
        }

        $("#bulan").removeAttr('class');
        $("#bulan").select2();

        $('input').on('click', function(){
            var valeur = 0;
            $('input:checked').each(function(){
                if ( $(this).attr('value') > valeur )
                {
                    valeur =  $(this).attr('value');
                }
            });
            $('.progress-bar').css('width', valeur+'%').attr('aria-valuenow', valeur);
        });

        $('#btnsub').on('click', function() {
            $.ajax({
                url: "{!! url('simpanan/proses/cek') !!}",
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    if (data[0]["stat"] == "FAIL") {
                        var judul = data[0]["title"];
                        var pesan = data[0]["psg"];
                        $('#judul').html("<h4 class='modal-title' id='judul'>" + judul + "</h4>");
                        $('#mess').html("<p id='mess'>" + pesan + "<p>");
                        $('#reModal').modal();
                    } else {
                        //alert("VALI");
                        FunctionLoading();
                        $('#fpro').submit();
                    }
                }

            });
        });
    </script>

@stop
