<input type="hidden" id="wwk" value="100">
<script>
    $('#btnsa').on('click', function() {
        if ($('#nama_pinjaman').val()=='') {
            $('#mtesttx').html("<h4 class='modal-title' id='mtestt'>Pilih Nama Pinjaman</h4>");
            $('#mtestx').html('<p id="mtest">Pilih nama pinjaman terlebih dahulu untuk Save.</p>');
            $('#reModal').modal();
        } else if ($('#kode_anggota').val() == "") {
            $('#mtesttx').html("<h4 class='modal-title' id='mtestt'>Pilih Kode Anggota</h4>");
            $('#mtestx').html("<p id='mtest'>Kode Anggota harus diisi lebih dahulu<p>");
            $('#reModal').modal();
        }  else if ($('#jangka_waktu').val() == "" || $('#jangka_waktu').val() == "0") {
            $('#mtesttx').html("<h4 class='modal-title' id='mtestt'>Jangka Waktu</h4>");
            $('#mtestx').html("<p id='mtest'>Jangka Waktu harus diisi lebih dahulu<p>");
            $('#reModal').modal();
        } else if ($('#jumlah-pengajuan').val() == "" || $('#jumlah-pengajuan').val() == "0.00") {
            $('#mtesttx').html("<h4 class='modal-title' id='mtestt'>Jumlah Pengajuan</h4>");
            $('#mtestx').html("<p id='mtest'>Jumlah Pengajuan harus diisi lebih dahulu<p>");
            $('#reModal').modal();
        }else {
            //if ($('#inibtn').val() == "tambah") {
                $.ajax({
                    url: "{!! url('pinjaman/cek') !!}/" + $('#kode_anggota').val(),
                    data: {},
                    dataType: "json",
                    type: "get",
                    success: function (data) {
                        if (data[0]["stat"] == "FAIL") {
                            var judul = data[0]["title"];
                            var pesan = data[0]["psg"];
                            $('#mtesttx').html("<h4 class='modal-title' id='mtestt'>" + judul + "</h4>");
                            $('#mtestx').html("<p id='mtest'>" + pesan + "<p>");
                            $('#reModal').modal();
                        } else {
                            $('#rejectModal').modal();
                            $('#btnselesai').on('click', function () {
                                $('#pstat').val("SELESAI");
                                FunctionLoading();
                                $('#fpinj').submit();
                            });

                            $('#btnlanjut').on('click', function () {
                                $('#pstat').val("LANJUT");
                                FunctionLoading();
                                $('#fpinj').submit();
                            });
                        }

                    }

                });
//            } else {
//                FunctionLoading();
//                $('#fpinj').submit();
//            }
        }
    });

    $('#jumlah-pengajuan').maskMoney();
    $('#jumlah-angsuran-pokok').maskMoney();
    $('#nilai').maskMoney();
    $('#adminbank').maskMoney();

    $('#kode_anggota').on('change', function() {
        var id = $('#kode_anggota option:selected').val();
        $.ajax({
            url: "{!! url('simpanan/ajax/anggota') !!}/"+id,
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

    $('#nama_pinjaman').change(function() {
        $('#nomor_pinjaman').load("{!! url('pinjaman/pengaturan/generate') !!}/"+ $(this).val());
        $('#suku_bunga').load("{!! url('pinjaman/pengaturan/sukubunga') !!}/"+ $(this).val());
        $('#sistem_bunga').load("{!! url('pinjaman/pengaturan/sistembunga') !!}/"+ $(this).val());
        //$('#adtw').load("{!! url('pinjaman/pengaturan/jkredit') !!}/"+ $(this).val());
        {{--$.ajax({--}}
            {{--url: "{!! url('pinjaman/pengaturan/jkredit2') !!}/"+ $(this).val(),--}}
            {{--data: {},--}}
            {{--dataType: "json",--}}
            {{--type: "get",--}}
            {{--success:function(data)--}}
            {{--{--}}
                {{--$('#perhitungan_bunga').val(data[0]["type"]).selected;--}}
            {{--}--}}
        {{--});--}}
    });

    $('#nomor_pinjaman_jamin').on('click', function () {
        $(this).val($('#no_pinjaman').val());
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imgfoto').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#foto").change(function(){
        readURL(this);
    });


    function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imgfoto2').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#foto2").change(function(){
        readURL2(this);
    });

    $("#tambah").on('click', function  () {
        $('#ttt').load('<h3 id="ttt">Tambah</h3>');
        $("#jamin").removeClass('hide');
        $("#jamin").show();
        $("#ptabel").hide();
        $('#pid').val("tos");
        $('#fot').val("fot");
        $('#fot2').val("fot2");
        $('#nomor_pinjaman_jamin').val($('#no_pinjaman').val());
        $('#pinid').val($('#idpin').val());
        $('#fjam')[0].reset();
        $('#imgfoto').attr('src', '{{asset("assets/img/avatar.jpg")}}');
        $('#imgfoto2').attr('src', '{{asset("assets/img/avatar.jpg")}}');
    });

    function isdelete(id) {
        swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this imaginary file!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',   cancelButtonColor: '#d33',
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                },
                function(){
                    swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    $('#table').load("{!! url('pinjaman/jaminan/delete') !!}/" + id + "/" + $('#idpin').val());
                });
    }

    function isedit(id) {
        $.ajax({
            url: "{!! url('pinjaman/jaminan/edit') !!}/" + id,
            data: {},
            dataType: "json",
            type: "get",
            success:function(data)
            {
                $('#ttt').load('<h3 id="ttt">Edit</h3>');
                $("#jamin").removeClass('hide');
                $("#jamin").show();
                $('#pid').val(id);
                $("#ptabel").hide();

                if(data[0]["jenis_jaminan"] == '1') {
                    $("#jsimpanan").removeClass('hide');
                    $("#jsimpanan").show();
                    $("#jemas").hide();
                    $("#jelektronik").hide();
                    $("#jkendaraan").hide();
                    $("#jbangunan").hide();
                    $("#jtanpa").hide();
                } else if(data[0]["jenis_jaminan"] == '2') {
                    $("#jemas").removeClass('hide');
                    $("#jemas").show();
                    $("#jsimpanan").hide();
                    $("#jelektronik").hide();
                    $("#jkendaraan").hide();
                    $("#jbangunan").hide();
                    $("#jtanpa").hide();
                } else if(data[0]["jenis_jaminan"] == '4') {
                    $("#jelektronik").removeClass('hide');
                    $("#jelektronik").show();
                    $("#jsimpanan").hide();
                    $("#jemas").hide();
                    $("#jkendaraan").hide();
                    $("#jbangunan").hide();
                    $("#jtanpa").hide();
                } else if(data[0]["jenis_jaminan"] == '3') {
                    $("#jkendaraan").removeClass('hide');
                    $("#jkendaraan").show();
                    $("#jsimpanan").hide();
                    $("#jelektronik").hide();
                    $("#jemas").hide();
                    $("#jbangunan").hide();
                    $("#jtanpa").hide();
                } else if(data[0]["jenis_jaminan"] == '5') {
                    $("#jbangunan").removeClass('hide');
                    $("#jbangunan").show();
                    $("#jsimpanan").hide();
                    $("#jelektronik").hide();
                    $("#jkendaraan").hide();
                    $("#jemas").hide();
                    $("#jtanpa").hide();
                } else if(data[0]["jenis_jaminan"] == '6') {
                    $("#jtanpa").removeClass('hide');
                    $("#jtanpa").show();
                    $("#jsimpanan").hide();
                    $("#jelektronik").hide();
                    $("#jkendaraan").hide();
                    $("#jbangunan").hide();
                    $("#jemas").hide();
                }

                $('#nomor_pinjaman_jamin').val(data[0]["nopinjaman"]);
                $('#jenis_jaminan').val(data[0]["jenis_jaminan"]);
                $('#ikatan_hukum').val(data[0]["ikatan_hukum"]);
                $('#nama_pemilik').val(data[0]["nama_pemilik"]);
                $('#alamat_pemilik').val(data[0]["alamat_pemilik"]);
                $('#nilai').val(data[0]["nilai"]);
                $('#nomor_arsip').val(data[0]["nomor_arsip"]);
                $('#keterangan_jamin').val(data[0]["keterangan"]);

                $('#nosimpanan').val(data[0]["nosimpanan"]);
                $('#jumlah').val(data[0]["jumlah"]);
                $('#bank').val(data[0]["bank"]);

                $('#nosertifikatemas').val(data[0]["nosertifikatemas"]);
                $('#berat').val(data[0]["berat"]);
                $('#karat').val(data[0]["karat"]);

                $('#noserial').val(data[0]["noserial"]);
                $('#tipee').val(data[0]["tipee"]);
                $('#mereke').val(data[0]["mereke"]);

                $('#nosertikattanah').val(data[0]["nosertifikattanah"]);
                $('#kelurahan').val(data[0]["kelurahan"]);
                $('#kecamatan').val(data[0]["kecamatan"]);
                $('#kota').val(data[0]["kota"]);
                $('#provinsi').val(data[0]["provinsi"]);
                $('#nib').val(data[0]["nib"]);
                $('#peruntukan').val(data[0]["peruntukan"]);
                $('#serhak').val(data[0]["serhak"]);
                $('#luastanah').val(data[0]["luastanah"]);

                $('#noplat').val(data[0]["noplat"]);
                $('#nobpkb').val(data[0]["nobpkb"]);
                $('#merekk').val(data[0]["merekk"]);
                $('#jenis').val(data[0]["jenis"]);
                $('#tahun').val(data[0]["tahun"]);
                $('#warna').val(data[0]["warna"]);
                $('#norangka').val(data[0]["norangka"]);
                $('#bahanbakar').val(data[0]["bahanbakar"]);
                $('#tipek').val(data[0]["tipek"]);
                $('#model').val(data[0]["model"]);
                $('#cc').val(data[0]["cc"]);
                $('#jmlroda').val(data[0]["jmlroda"]);
                $('#nomesin').val(data[0]["nomesin"]);

                $('#nom').val(data[0]["nomor"]);

                $('#jenis_jaminan').load("{!! url('pinjaman/jaminan/jenis') !!}/" + data[0]["jenis_jaminan"]);
                $('#ikatan_hukum').load("{!! url('pinjaman/jaminan/ikatan') !!}/" + data[0]["ikatan_hukum"]);

                $('fot').val(data[0]["fot"]);
                $('fot2').val(data[0]["fot2"]);

                $('#imgfoto').attr('src', '{{asset("foto/jaminan")}}/' + data[0]["fot"]);
                $('#imgfoto2').attr('src', '{{asset("foto/jaminan")}}/'  + data[0]["fot2"]);

            }

        });
    }

    $('#tanggal_pengajuan').on('change', function() {
        var df = $('#tanggal_pengajuan').val();
        df = df.split('/');
        var dfrom = df[2] + "-" + df[0] + "-" + df[1];

        var sel = $('#jangka_waktu').val();

        $.ajax({
            url: "{!! url('pinjaman/cek/tempo') !!}/" + dfrom + "/" + sel,
            data: {},
            dataType: "json",
            type: "get",
            success:function(data)
            {
                $('#jatuh-tempo').val(data[0]["tgl"]);
            }

        });
    });

    $('#jumlah-pengajuan').on('change', function() {
        var formData = {
            'waktu'  : $('#jangka_waktu').val(),
            'pengajuan'    : $('#jumlah-pengajuan').val()
        };

        $.ajax({
            url: "{!! url('pinjaman/ajax') !!}",
            data: formData,
            dataType: "json",
            type: "get",
            success:function(data)
            {
                $('#jumlah-angsuran-pokok').val(data[0]["angsur"]);
            }
        });
    });

    function minmax() {
        //alert("{!! url('pinjaman/wwk') !!}/" + $('#nama_pinjaman').val() + "/" + $('#jangka_waktu').val());
        $.ajax({
            url: "{!! url('pinjaman/wwk') !!}/" + $('#nama_pinjaman').val() + "/" + $('#jangka_waktu').val(),
            data: {},
            dataType: "json",
            type: "get",
            success:function(data)
            {
                $('#jangka_waktu').val(data[0]["hs"]);

                var df = $('#tanggal_pengajuan').val();
                df = df.split('/');
                var dfrom = df[2] + "-" + df[0] + "-" + df[1];

                var sel = data[0]["hs"];

                $.ajax({
                    url: "{!! url('pinjaman/cek/tempo') !!}/" + dfrom + "/" + sel + "/" + $('#nama_pinjaman').val(),
                    data: {},
                    dataType: "json",
                    type: "get",
                    success:function(data)
                    {
                        $('#jatuh-tempo').val(data[0]["tgl"]);
                    }

                });


                var formData = {
                    'waktu'  : data[0]["hs"],
                    'pengajuan'    : $('#jumlah-pengajuan').val()
                };

                $.ajax({
                    url: "{!! url('pinjaman/ajax') !!}",
                    data: formData,
                    dataType: "json",
                    type: "get",
                    success:function(data)
                    {
                        $('#jumlah-angsuran-pokok').val(data[0]["angsur"]);
                    }
                });
            }

        });


    }

    $('#jenis_jaminan').on('change', function() {
        if($(this).val() == '1') {
            $("#jsimpanan").removeClass('hide');
            $("#jsimpanan").show();
            $("#jemas").hide();
            $("#jelektronik").hide();
            $("#jkendaraan").hide();
            $("#jbangunan").hide();
            $("#jtanpa").hide();
        } else if($(this).val() == '2') {
            $("#jemas").removeClass('hide');
            $("#jemas").show();
            $("#jsimpanan").hide();
            $("#jelektronik").hide();
            $("#jkendaraan").hide();
            $("#jbangunan").hide();
            $("#jtanpa").hide();
        } else if($(this).val() == '4') {
            $("#jelektronik").removeClass('hide');
            $("#jelektronik").show();
            $("#jsimpanan").hide();
            $("#jemas").hide();
            $("#jkendaraan").hide();
            $("#jbangunan").hide();
            $("#jtanpa").hide();
        } else if($(this).val() == '3') {
            $("#jkendaraan").removeClass('hide');
            $("#jkendaraan").show();
            $("#jsimpanan").hide();
            $("#jelektronik").hide();
            $("#jemas").hide();
            $("#jbangunan").hide();
            $("#jtanpa").hide();
        } else if($(this).val() == '5') {
            $("#jbangunan").removeClass('hide');
            $("#jbangunan").show();
            $("#jsimpanan").hide();
            $("#jelektronik").hide();
            $("#jkendaraan").hide();
            $("#jemas").hide();
            $("#jtanpa").hide();
        } else if($(this).val() == '6') {
            $("#jtanpa").removeClass('hide');
            $("#jtanpa").show();
            $("#jsimpanan").hide();
            $("#jelektronik").hide();
            $("#jkendaraan").hide();
            $("#jbangunan").hide();
            $("#jemas").hide();
        }
    });

    $("#sub").on('click', function  () {
        $("#ptabel").removeClass('hide');
        $("#ptabel").show();
        $("#jamin").hide();
    });

    $("#subbb").on('click', function () {
        if($('#pinid').val() == "null") {
            $('#mtesttx').html("<h4 class='modal-title' id='mtestt'>Pinjaman</h4>");
            $('#mtestx').html("<p id='mtest'>Data Pinjaman harus di Simpan lebih dahulu<p>");
            $('#reModal').modal();
        } else {
            FunctionLoading();
            $('#fjam').submit();
        }
    });

    $("#status-pasangan").removeAttr('class');
    $("#status-pasangan").select2();

//    $("#jenis_jaminan").removeAttr('class');
//    $("#jenis_jaminan").select2();
//    $("#ikatan_hukum").removeAttr('class');
//    $("#ikatan_hukum").select2();

    $('#btnsimulasi').on('click', function() {

        if($('#no_pinjaman').val() == '') {
            $('#mtesttx').html('<h4 id="mtestt" class="modal-title">Pilih Jenis Pinjaman</h4>');
            $('#mtestx').html('<p id="mtest">Pilih jenis pinjaman terlebih dahulu untuk melihat simulasi.</p>');
            $('#reModal').modal();
        }else if($('#nama_anggota').val() == '') {
            $('#mtesttx').html('<h4 id="mtestt" class="modal-title">Pilih Anggota</h4>');
            $('#mtestx').html('<p id="mtest">Pilih anggota terlebih dahulu untuk melihat simulasi.</p>');
            $('#reModal').modal();
        } else if($('#jumlah-pengajuan').val() == '0.00' || $('#jangka_waktu').val() == '0'){
            $('#mtesttx').html('<h4 id="mtestt" class="modal-title">Jumlah pengajuan dan jangka waktu</h4>');
            $('#mtestx').html('<p id="mtest">Isi data jumlah pengajuan dan jangka waktu terlebih dahulu untuk melihat simulasi.</p>');
            $('#reModal').modal();
        }else {
            $('.bungatr').remove();
            $('#id_simulasi').val($('#nama_pinjaman').val());
            $('#nama_simulasi').val($('#nama_anggota').val());
            $('#bunga_simulasi').val($('#suku-bunga').val());
            $('#jangkawaktu_simulasi').val($('#jangka_waktu').val());
            $('#jmlpengajuan_simulasi').val($('#jumlah-pengajuan').val());
            $('#tgl_pengajuan').val($('#tanggal_pengajuan').val());
            $('#jth_tempo').val($('#jatuh-tempo').val());
            $('#angsuran_simulasi').val($('#jumlah-angsuran-pokok').val());
            $('#sistem_bungasim').val($('#simb').val());
            $('#simulasiModal').modal();


            var formData = {
                'waktu'  : $('#jangka_waktu').val(),
                'pengajuan'    : $('#jumlah-pengajuan').val(),
                'bunga'         : $('#bunga_simulasi').val(),
                'hitung'        : $('#perhitungan_bunga').val()
            };
            $.ajax({
                url: "{{ url('pinjaman/sistemsimulasi') }}/"+$('#simbid').val()+"/"+$('#id_simulasi').val(),
                data: formData,
                type: "get",
                success:function(data)
                {
                    $('#bodybunga').html($('#bodybunga').html()+data);
                }
            });

        }
    });

    $('#sistem_bungasim').on('change',function() {

        if ($(this).val()=='') {
            $('.bungatr').remove();
        }

        else {
            $('.bungatr').remove();
            var formData = {
                'waktu'  : $('#jangka_waktu').val(),
                'pengajuan'    : $('#jumlah-pengajuan').val(),
                'bunga'         : $('#bunga_simulasi').val(),
                'hitung'        : $('#perhitungan_bunga').val()
            };
            $.ajax({
                url: "{{ url('pinjaman/sistemsimulasi') }}/"+$(this).val()+"/"+$('#id_simulasi').val(),
                data: formData,
                type: "get",
                success:function(data)
                {
                    $('#bodybunga').html($('#bodybunga').html()+data);
                }
            });
        }
    });



    // PENGATURAN

    $("#jml-denda").maskMoney();
    $("#sistem-bunga").removeAttr('class');
    $("#sistem-bunga").select2();
    $("#shu").removeAttr('class');
    $("#shu").select2();
    $("#tipepinjaman").removeAttr('class');
    $("#tipepinjaman").select2();
    //        $("#tipe-denda-perhari").removeAttr('class');
    //        $("#tipe-denda-perhari").select2();

    $("#akun-kas-bank").removeAttr('class');
    $("#akun-kas-bank").select2();
    $("#akun-realisasi").removeAttr('class');
    $("#akun-realisasi").select2();
    $("#akun-angsuran").removeAttr('class');
    $("#akun-angsuran").select2();
    $("#akun-bunga").removeAttr('class');
    $("#akun-bunga").select2();
    $("#akun-administrasi").removeAttr('class');
    $("#akun-administrasi").select2();
    $("#akun-administrasi-bank").removeAttr('class');
    $("#akun-administrasi-bank").select2();
    $("#akun-administrasi-tambahan").removeAttr('class');
    $("#akun-administrasi-tambahan").select2();
    $("#akun-denda").removeAttr('class');
    $("#akun-denda").select2();
    $("#biaya-provinsi").removeAttr('class');
    $("#biaya-provinsi").select2();
    $("#akun-lain-lain").removeAttr('class');
    $("#akun-lain-lain").select2();
    $("#akun-hapus-pinjaman").removeAttr('class');
    $("#akun-hapus-pinjaman").select2();
    $("#akun-piutang-pinjaman").removeAttr('class');
    $("#akun-piutang-pinjaman").select2();
    $("#akun-tampungan-pinjaman").removeAttr('class');
    $("#akun-tampungan-pinjaman").select2();
    $("#akun-piutang-tak-tertagih").removeAttr('class');
    $("#akun-piutang-tak-tertagih").select2();

</script>
