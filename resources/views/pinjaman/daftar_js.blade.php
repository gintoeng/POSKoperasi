<div class="modal fade" id="reModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="mtestt" class="modal-title">Hapus Pinjaman</h4>
            </div>
            <div class="modal-body">
                <p id="mtest">Maaf Data Pinjaman tidak dapat dihapus karena sudah di Realisasi.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#realis').change(function() {
        var real = $('input:radio[name=realisasi]:checked').val();
        var kolek = $('#kolektibilitas').val();
        location.href = "{!! url('pinjaman/search') !!}/"+kolek+"/"+real;
    });

    $('#kolektibilitas').change(function() {
        var real = $('input:radio[name=realisasi]:checked').val();
        var kolek = $('#kolektibilitas').val();
        location.href = "{!! url('pinjaman/search') !!}/"+kolek+"/"+real;
    });

    function cekreal(idp) {

        $.ajax({
            url: "{!! url('pinjaman/cekreal') !!}/" + idp,
            data: {},
            dataType: "json",
            type: "get",
            success:function(data)
            {
                var real = data[0]["statreal"];

                if(real == "Y") {
                    $('#mtestt').html('<h4 id="mtestt" class="modal-title">Hapus Pinjaman</h4>');
                    $('#mtest').html('<p id="mtest">Maaf Data Pinjaman tidak dapat dihapus karena sudah di Realisasi.</p>');
                    $('#reModal').modal();
                } else {
                    swal({
                        title: "Apakah Anda Yakin?",
                        text: "Data Pembayarannya Pinjaman ini juga akan Terhapus !",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',   cancelButtonColor: '#d33',
                                confirmButtonText: "Yes, delete it!",
                                closeOnConfirm: false
                    }).then(function() {
                        swal("Deleted!", "Pinjaman Telah Terhapus.", "success");
                        location.href =  "{{ url('pinjaman') }}/" + idp + "/destroy";
                    })
                }
            }
        });
    };

    function cekrealup(idp) {

        $.ajax({
            url: "{!! url('pinjaman/cekreal') !!}/" + idp,
            data: {},
            dataType: "json",
            type: "get",
            success:function(data)
            {
                var real = data[0]["statreal"];

                if(real == "Y") {
                    $('#mtestt').html('<h4 id="mtestt" class="modal-title">Ubah Pinjaman</h4>');
                    $('#mtest').html('<p id="mtest">Maaf Data Pinjaman tidak dapat diubah karena sudah di Realisasi.</p>');
                    $('#reModal').modal();
                } else {
                    location.href = "{!! url('pinjaman') !!}/" + idp + "/edit";
                }
            }
        });
    };

    function kol(idp) {

        $.ajax({
            url: "{!! url('pinjaman/setkol') !!}/" + idp,
            data: {},
            dataType: "json",
            type: "get",
            success:function(data)
            {

            }
        });
    };
</script>
