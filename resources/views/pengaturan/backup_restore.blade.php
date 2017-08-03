@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Pengaturan</a>
        </li>
        <li class="active"><a href="{!! url('pengaturan/backup') !!}">Backup & Restore</a></li>
    </ol>
    <div class="row">

        <div class="col-md-4">
            <section class="panel no-b">
                <div class="panel-body">
                    <center><font size="4">Backup</font></center>
                    <hr>
                    <h5>Manual Backup</h5>
                    <p>Manually backup database on server or save it to local computer.</p>
                    <p><strong>Latest backup:</strong><br> {{ \Carbon\Carbon::createFromFormat('YmdHis', str_replace('.sql', '',last(explode("_",last($files)))))->toDayDateTimeString() }}</p>
                    <hr/>
                    <a href="{{ url('pengaturan/backup-restore/backup') }}" onclick="FunctionLoading()" class="btn btn-primary">Backup Now</a>
                    <a href="{{ url('pengaturan/backup-restore/backup/download') }}" onclick="FunctionLoading()" class="btn btn-success">Backup & Download</a>
                </div>
            </section>
        </div>

        <div class="col-md-8">
            <section class="panel no-b">
                <div class="panel-body">
                    <center><font size="4">Restore</font></center>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ url('pengaturanbackup-restore/restore') }}" method="post" id="fres">
                                {{ csrf_field() }}
                                <h5>Restore from server</h5>
                                <p>Restore database from backup data on server</p>
                                <div class="form-group">
                                    <select class="form-control" name="filename" required id="filename" style="width: 100%" data-placeholder="Select Backup">
                                        <option value="">Select Backup</option>
                                        @foreach($files as $file)
                                            <option value="{{ $file }}">{{ $file }}</option>
                                        @endforeach
                                    </select>
                                    <p class="small help-block"><i class="icon md-alert-circle"></i> Warning! you are about to replace database with current restore</p>
                                </div>
                                <hr/>
                                <button type="button" class="btn btn-danger" onclick="restore()">Restore</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ url('pengaturan/backup-restore/restore/local') }}" method="post" enctype="multipart/form-data" id="fresloc">
                                {{ csrf_field() }}
                                <h5>Restore from local computer</h5>
                                <p>Restore database from local computer</p>
                                <div class="form-group">
                                    <div class="input-group input-group-file">
                                        <input type="file" name="foto" class="form-control" id="foto" required>
                                        {{--<span class="input-group-btn">--}}
                                        {{--<span class="btn btn-success btn-file waves-effect waves-light">--}}
                                        {{--<i class="icon md-upload" aria-hidden="true"></i>--}}
                                        {{--<input type="file" name="restore" >--}}
                                        {{--</span>--}}
                                        {{--</span>--}}
                                    </div>
                                    <p class="small help-block"><i class="icon md-alert-circle"></i> Warning! you are about to replace database with current restore</p>
                                </div>
                                <hr/>
                                <button type="button" class="btn btn-danger" onclick="restoreloc()">Restore</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    @include('master.modal_js')
    <script>
        $("#filename").removeAttr('class');
        $("#filename").select2();
        function restore() {
            if($('#filename').val() == '') {
                $('#judul').html('<h4 class="modal-title" id="judul">Restore</h4>');
                $('#mess').html('<p id="mess">Pilih file backup lebih dahulu.</p>');
                $('#rejectModal').modal();
            } else {
                swal({
                    title: "Apakah Anda Yakin?",
                    text: "Database yang sudah ada akan di replace !",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "Yes, replace it!",
                    closeOnConfirm: false
                }).then(function () {
                    swal("Replaced!", "Your database file has been replaced.", "success");
                    $('#fres').submit();
                })
            }
        }

        function restoreloc() {
            if($('#foto').val() == '') {
                $('#judul').html('<h4 class="modal-title" id="judul">Restore</h4>');
                $('#mess').html('<p id="mess">File tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else {
                swal({
                    title: "Apakah Anda Yakin?",
                    text: "Database yang sudah ada akan di replace !",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "Yes, replace it!",
                    closeOnConfirm: false
                }).then(function () {
                    swal("Replaced!", "Your database file has been replaced.", "success");
                    $('#fresloc').submit();
                })
            }
        }
    </script>

@stop
