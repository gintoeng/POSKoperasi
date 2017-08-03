<div class="modal fade" id="reModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel">
    <div class="modal-dialog modal-center">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="mtestt" class="modal-title">Attach Document</h4>
            </div>
            <form action="" method="post" enctype="multipart/form-data" id="formdoc">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" id="idp" value="" name="idp">
                <div class="modal-body">
                    <div class="row hide" id="fmdoc">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="file" class="col-sm-3 control-label">File</label>
                                <div class="col-sm-9">
                                    <input name="filedoc" value="" type="file" class="form-control" id="file" placeholder="File" required>
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label for="ket" class="col-sm-3 control-label">Keterangan</label>
                                <div class="col-sm-9">
                                    <textarea name="keterangan" class="form-control" id="ket" placeholder="Keterangan"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="tbldoc">
                        <div class="col-md-12">
                            <div class="pull-left">
                                <a href="javascript:void(0)" onclick="tambah()" class="btn btn-primary mb15"><i class="ti ti-plus"></i> Tambah</a>
                            </div>
                            <div class="table-responsive no-border" id="table-simulasi">
                                <table id="tabdoc" class="table table-bordered table-striped no-m scroll" style="display: -moz-groupbox;">
                                    <thead>
                                    <tr style="background-color: dodgerblue; color: white; width: 100%;">
                                        <th class="text-center" width="50">No.</th>
                                        <th class="text-center">Keterangan</th>
                                        <th class="text-center">File</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnoke" class="btn btn-primary" data-dismiss="modal">OKE</button>
                    <div class="row hide" id="btndoc">
                        <div class="col-md-2 pull-left">
                            <button type="button" id="btncandoc" class="btn btn-danger">Cancel</button>
                        </div>
                        <div class="col-md-10 pull-right">
                            <button type="button" id="btnsavedoc" class="btn btn-primary" data-dismiss="modal"><i class="ti-save"> Save</i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="reModal2" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="mtestt" class="modal-title">Attach Document</h4>
            </div>
            <div class="modal-body">
                <p id="mtest">Maaf File Harus Diisi !</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
            </div>
        </div>
    </div>
</div>

<script>
    function konfirm(id) {
        swal({
                    title: "Apakah Anda Yakin?",
                    text: "Data Pinjaman dan Pembayarannya yg menggunakan Pengaturan ini juga akan Terhapus !",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',   cancelButtonColor: '#d33',
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
        }).then(function() {
            swal("Deleted!", "Pengaturan Telah Terhapus.", "success");
            location.href =  "{{ url('pinjaman/pengaturan') }}/" + id + "/destroy";
        })

    }

    function doc(id) {
        $('#tabdoc').load("{{url('pinjaman/pengaturan/attach/doc')}}/" + id);
        $('#formdoc').attr('action', '{{ url('pinjaman/pengaturan/attach') }}');
        $('#idp').val(id);
        $('#reModal').modal();
    }

    function tambah() {
        $('#tbldoc').hide();
        $('#btnoke').hide();
        $('#btndoc').removeClass('hide');
        $('#btndoc').show();
        $('#fmdoc').removeClass('hide');
        $('#fmdoc').show();
    }

    function hapus(id) {
        $('#tabdoc').load("{{url('pinjaman/pengaturan/attach/destroy')}}/" + id + "/" + $('#idp').val());
    }

    function down(id) {
        window.open("{{url('pinjaman/pengaturan/attach/download')}}/" + id);
    }

    function pre(id) {
        window.open("{{url('pinjaman/pengaturan/attach/preview')}}/" + id);
    }

    $('#btncandoc').on('click', function() {
        $('#fmdoc').hide();
        $('#btndoc').hide();
        $('#btnoke').removeClass('hide');
        $('#btnoke').show();
        $('#tbldoc').removeClass('hide');
        $('#tbldoc').show();
    });

    $('#btnsavedoc').on('click', function() {
        if ($('#file').val() == "") {
            $('#reModal2').modal();
        } else {
            $('#formdoc').submit();
        }
    });

</script>
