@extends('layouts.master')

@section('content')

<div class="row">
    <div class="col-md-6">
        <a href="#" class="btn btn-sm btn-info mb5"><i class="ti-printer mr5"></i>Cetak</a>
    </div>
    <div class="col-md-6">
        <div class="pull-right">
            Total data : {!! $JurnalHeaderAlljml !!}
        </div>
    </div>
</div>
<div class="row">
    <form class="form-horizontal" role="form" method="post" action="{!! url('akuntansi/jurnal/posting') !!}">
    <div class="col-md-12">
        <div class="table-responsive no-border">
            <table class="table table-bordered table-striped mg-t editable-datatable">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">No. Transaksi</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Akun</th>
                        <th class="text-center">Nama Akun</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Debet</th>
                        <th class="text-center">Kredit</th>
                        <th><input type="checkbox" name="checkAll" id="TableAll"></th>
                    </tr>
                </thead>
                <tbody>
                    @if($JurnalHeaderAlljml <= 0)
                        <tr>
                            <td colspan="10"><center>Data Tidak Ada</center></td>
                        </tr>
                    @else
                        <?php
                            $i = 1;
                            $prev_kode_jurnalAll = '';
                        ?>
                        @foreach($JurnalHeaderAll as $row)
                            <?php
                                if($akun_perkiraan=="semua" or $akun_perkiraan ==""){
                                    $JurnalDetailAll = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->get();
                                    $total_detailAll = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->count();
                                } else {
                                    $JurnalDetailAll = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->where('id_akun', $akun_perkiraan)->get();
                                    $total_detailAll = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->where('id_akun', $akun_perkiraan)->count();
                                }

                            ?>
                            @foreach($JurnalDetailAll as $datajurnal)
                            <tr>
                                <td class="text-center">{!! $i++ !!}.</td>
                                <?php
                                    if($row['kode_jurnal'] != $prev_kode_jurnalAll){
                                        echo '<td rowspan="'.$total_detailAll.'">'.$row['kode_jurnal'].'</td>';
                                    }
                                ?>
                                <td class="text-center"><?php echo substr($row['tanggal'], 0,10); ?></td>
                                @if($datajurnal->posting==1)
                                <td style="color:blue;"><center> Sudah diposting </center></td>
                                @else
                                <td style="color:red;"><center> Blm diposting </center></td>
                                @endif
                                <?php
                                    $akun = App\Model\Akuntansi\Perkiraan::find($datajurnal->id_akun);
                                ?>
                                <td>{!! $akun['kode_akun'] !!}</td>
                                <td>{!! $akun['nama_akun'] !!}</td>
                                <td>{!! $row->keterangan !!}</td>
                                <td class="text-right">Rp. <?php echo number_format($datajurnal->debet, '2');?></td>
                                <td class="text-right">Rp. <?php echo number_format($datajurnal->kredit, '2');?></td>
                                <?php
                                    if($row['kode_jurnal'] != $prev_kode_jurnalAll){
                                        if($datajurnal->posting==1){
                                            echo '<td rowspan="'.$total_detailAll.'"><input type="checkbox" disabled placeholder="" name="cbpilih['.$row->id.']"/></td>';
                                        } else {
                                            echo '<td rowspan="'.$total_detailAll.'"><input type="checkbox" placeholder="" name="cbpilih['.$row->id.']"/></td>';
                                        }
                                    }
                                ?>
                                <?php $prev_kode_jurnalAll = $row['kode_jurnal']; ?>
                            </tr>
                            @endforeach
                        @endforeach
                    @endif
                </tbody>
            </table>

            {!! $JurnalHeaderAll->links() !!}


            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="pull-right">
                <button type="submit" class="btn btn-sm btn-danger mb5"><i class="ti-check mr5"></i>Posting</button>
            </div>
        </div>
    </div>
    </form>
</div>


<script type="text/javascript">

    function ceknomor(){
       $.ajax({
           url: "{!! url('akuntansi/jurnal/ceknomor') !!}",
           data: {},
           dataType: "json",
           type: "get",
           success:function(data)
           {
               if (data[0]["stat"] == "kosong") {
                   $('#rejectModal').modal();
               } else {
                       location.href = "{!! url('akuntansi/jurnal/create') !!}";
               }
           }

       });
    };

	$('#search_form .input-daterange').datepicker({
		format: "yyyy-mm-dd",
		todayHighlight: true,
		autoclose: true
	});

    $('#TableManual').click(function (e) {
        $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    });
    $('#TableAll').click(function (e) {
        $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    });
    $('#TableTabungan').click(function (e) {
        $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    });
    $('#TableKredit').click(function (e) {
        $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    });
    // $('#TableDeposito').click(function (e) {
    //     $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    // });
    $('#TableKas').click(function (e) {
        $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    });
</script>
@stop
