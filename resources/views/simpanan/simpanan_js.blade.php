<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="judul"></h4>
            </div>
            <div class="modal-body">
                <p id="mess">Anda TIDAK bisa melakukan PENARIKAN atau TRANSFER</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#btnsave').on('click', function() {
        if ($('#jenis_simpanan').val() == "") {
            $('#judul').html("<h4 class='modal-title' id=''judul'>Pilih Jenis Simpanan</h4>");
            $('#mess').html("<p id='mess'>Jenis Simpanan harus diisi lebih dahulu<p>");
            $('#rejectModal').modal();
        }else if ($('#kode_anggota').val() == "") {
            $('#judul').html("<h4 class='modal-title' id=''judul'>Pilih Kode Anggota</h4>");
            $('#mess').html("<p id='mess'>Kode Anggota harus diisi lebih dahulu<p>");
            $('#rejectModal').modal();
        }else  {
            $.ajax({
                url: "{!! url('simpanan/cek') !!}/" + $('#kode_anggota').val() + "/" + $('#jenis_simpanan').val() + "/" +  $('#setoran_bulanan').val() + "/" +  $('#saldo_blokir').val(),
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    if (data[0]["stat"] == "FAIL") {
                        var judul = data[0]["title"];
                        var pesan = data[0]["psg"];
                        $('#judul').html("<h4 class='modal-title' id=''judul'>" + judul + "</h4>");
                        $('#mess').html("<p id='mess'>" + pesan + "<p>");
                        $('#rejectModal').modal();
                    } else {
                        FunctionLoading();
                        $('#fsimp').submit();
                    }

                }

            });
        }
    });

    $('#setoran_bulanan').maskMoney();
    $('#saldo_blokir').maskMoney();

    $('#kode_anggota').on('change', function() {
        $.ajax({
            url: "{!! url('simpanan/ajax/anggota') !!}/" + $(this).val(),
            data: {},
            dataType: "json",
            type: "get",
            success:function(data)
            {
                $('#nama_anggota').val(data[0]["nama"]);
                $('#alamat_anggota').val(data[0]["alamat"]);
            }

        });
    });

    $('#jenis_simpanan').change(function() {
        $('#nomor_simpanan').load("{!! url('simpanan/pengaturan/generate') !!}/"+ $(this).val());
        $('#suku_bunga').load("{!! url('simpanan/pengaturan/sukubunga') !!}/"+ $(this).val());
        $('#sistem_bunga').load("{!! url('simpanan/pengaturan/sistembunga') !!}/"+ $(this).val());

        $.ajax({
            url: "{!! url('simpanan/ajax/cekstatus') !!}/" + $(this).val(),
            data: {},
            dataType: "json",
            type: "get",
            success:function(data)
            {
                if(data[0]["status"] == 0) {
                    $('#jwaktu').removeClass('hide');
                    $('#jwaktu').show();
                } else {
                    $('#jwaktu').hide();
                }
            }

        });
    });


    //PENGATURAN

//    $('#kode').on('change', function () {
//        var sem =  $('#setoran_minimum').val();
//        var number1 = Number(sem.replace(/[^0-9\.]+/g,""));
//        var sam = $('#saldo_minimum').val();
//        var number2 = Number(sam.replace(/[^0-9\.]+/g,""));
//        alert(number1 + number2);
//    });
    $("#saldo_minimum_bunga").maskMoney();
    $("#saldo_minimum").maskMoney();
    $("#saldo_minimum_pajak").maskMoney();
    $("#saldo_minimum_shu").maskMoney();
    $("#setoran_minimum").maskMoney();
    $("#administrasi").maskMoney();
    $("#autodebet").maskMoney();


    $("#akun-kas-bank").removeAttr('class');
    $("#akun-kas-bank").select2();
    $("#akun-setoran").removeAttr('class');
    $("#akun-setoran").select2();
    $("#akun-penarikan").removeAttr('class');
    $("#akun-penarikan").select2();
    $("#akun-bunga").removeAttr('class');
    $("#akun-bunga").select2();
    $("#akun-administrasi").removeAttr('class');
    $("#akun-administrasi").select2();
    $("#akun-pajak").removeAttr('class');
    $("#akun-pajak").select2();

    $("#shu").removeAttr('class');
    $("#shu").select2();

    $("#sistem-bunga").removeAttr('class');
    $("#sistem-bunga").select2();

</script>
