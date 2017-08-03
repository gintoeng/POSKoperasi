<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="judul">Pilih nomor pinjaman</h4>
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
    function cek(btn) {
        $.ajax({
            url: "{!! url('master/customer/cek') !!}",
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
                    if (btn == "tambah") {
                        location.href = "{!! url('master/customer/create') !!}";
                    } else {
                        location.href = "{!! url('master/customer/import') !!}";
                    }
                }
            }

        });
    };

    function konfirm(id) {
        swal({
                    title: "Apakah anda yakin?",
                    text: "Data Simpanan dan Data Pinjaman dari Customer ini juga akan terhapus.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',   cancelButtonColor: '#d33',
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
        }).then(function() {
            swal("Deleted!", "Your imaginary file has been deleted.", "success");
            location.href =  "{{ url('master/customer') }}/" + id + "/destroy";
        })

    }

</script>
