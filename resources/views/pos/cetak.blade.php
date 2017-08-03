<button id="ctk" style="border:none;width:38%;height:15%;background-color:#3498db;margin-top:13%;margin-left:52.5%;font-size:14pt;text-align:center;color:#fff;position:absolute;cursor:pointer;"><b>Cetak Laporan Harian</b></button>
<input id="rolenya" type="hidden" value="{{ $rolenya }}">
<button id="hpp" style="width:38%;height:15%;border:none;margin-top:13%;margin-left:11%;background-color:#3498db;text-align:center;color:#fff;position:absolute;font-size:14pt;cursor:pointer;"><b>Cetak Laporan HPP Harian</b></button>
<script type="text/javascript">

    $("#ctk").click(function(){

        var kasir = $('#rolenya').val();

        window.open("{!! url('pos/kasir/harian/kasir/cetak') !!}/"+ kasir);


    });
    $("#hpp").click(function(){

        var kasir = $('#rolenya').val();

        window.open("{!! url('pos/laporan') !!}");


    });
</script>
