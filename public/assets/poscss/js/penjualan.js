

$("#barcode").select2({
    placeholder: "",
    allowClear: true
});

var ini = $('#statusnya').val();
var rolenya = $('#rolenya').val();

if (rolenya==4)
{
    $('#buttonnya').css('display','none');
}
else
{
    $('#buttonnya').css('display','block');
}

if (ini==0) {

    $('#imagenya').css('display','none');
    $('#1nya').css('width','90.3%');
    $('#1nya').css('margin-left','4.1%');
    $('#1nya').css('margin-top','3%');
    $('#ceksaldo').css('left','77.7%');
    $('#payment').css('left','77.7%');
    $('#btngantiqty').css('left','63.1%');
    $('#void').css('left','64.1%');
//    $('#btnesc').css('left','51.6%');
//    $('#divesc').css('margin-left','57.1%');
    $('#btnretur').css('margin-left','48.5%');
    $('#labeltotal').css('margin-left','60%');
    $('#btntotal').css('margin-left','72.6%');
    $('#hold').css('left','51.6%');
    $('#divinput').css('margin-left','59.6%');
    $('#carikode').	css('left','81%');
//    $('#ctklaporan').	css('margin-left','37%');
    $('#produktdk').css('margin-left','60%');


}
else
{
    $('#imagenya').css('display','block');
    $('#1nya').css('width','76.3%');
    $('#produktdk').css('margin-left','45.5%');
    $('#1nya').css('margin-left','4.1%');
    $('#1nya').css('margin-top','5.7%');
    $('#ceksaldo').css('left','63.7%');
    $('#payment').css('left','63.7%');
    $('#btngantiqty').css('left','50.1%');
    $('#void').css('left','51.1%');
//    $('#btnesc').css('left','37.5%');
    $('#btnretur').css('margin-left','34.5%');
//    $('#ctklaporan').css('margin-left','23.5%');
//    $('#divesc').css('margin-left','43%');
    $('#labeltotal').css('margin-left','46%');
    $('#btntotal').css('margin-left','55.5%');
    $('#hold').css('left','37.5%');
    $('#divinput').css('margin-left','45.6%');
    $('#carikode').css('left','67%');
}


$('#btngantiqty').trigger('clik');
$('#btnesc').trigger('clik');
$('#btnpayment').trigger('clik');
$('#btnvoid').trigger('clik');
$('#btnhold').trigger('clik');
$('#btnceksaldo').trigger('clik');
$('#btnretur').trigger('clik');


function button3Click(id) {

    $("#Eqty").keyup(function (e) {
        if (e.keyCode == 13) {

            var f = $('#Eqty').val();



            $.ajax({
                url: "{!! url('pos/ubah/qty/enter') !!}" + "/" + id + "/" + f,
                data: {},
                dataType: "json",
                type: "get",
                success: function (data) {
                    location.reload();
                }
            });
        }
    });
}

$("#ctklaporan").click(function(){

    $('#divctk').load("{!! URL::to('/pos/cetak') !!}/");

});

$("#barcode").keyup(function (e) {



    if (e.keyCode == 13) {
        location.href =  "{{ url('pos/penjualan') }}" + "/" + $('#barcode').val();



    }

    else if (e.keyCode == 27) {

        var rolenya = $('#rolenya').val();

        if (rolenya==4) {


            location.href="{!! url('logout') !!}";
        }
        else
        {
            location.href="{!! url('pos/index') !!}";
        }


    }

    else if (e.keyCode == 118) {

        var total =  $('#input').val();
        var norefff = $('#norefnya').val();

        if (total==0)
        {

            location.href="{{url('pos/tahan')}}";

        }
        else
        {

            swal({
                title: "Apa anda yakin ingin menahan transaksi ? ",
                text: "Transaksi akan ditahan bila di klik",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',   cancelButtonColor: '#d33',
                confirmButtonText: "Yes",
                closeOnConfirm: true
            }).then(function() {
                swal("", "Transaksi berhasil ditahan", "success");
                location.href =  "{{ url('pos/penjual/hod') }}" + "/" + norefff;
            });


        }
    }

    else if (e.keyCode == 120) {

        var rolenya = $('#rolenya').val();

        if (rolenya==4)
        {
            $('#divvoid').load("{!! URL::to('/pos/supervisor/permission') !!}/");
        }
        else
        {

            $("#divvoid").hide();
            document.getElementById('fade4').style.display='none';

            swal({
                title: "Apa anda yakin ingin membatalkan transaksi ? ",
                text: "Transaksi akan dibatalkan bila di klik",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',   cancelButtonColor: '#d33',
                confirmButtonText: "Yes",
                closeOnConfirm: false
            }).then(function() {
                swal("", "Transaksi berhasil dibatalkan", "success");
                location.href =  "{{ url('pos/void') }}";
            });

        }


    }



    else if (e.keyCode == 115) {

        var total = $('#input').val();

        if (total == 0) {
            sweetAlert("Oops...", "Tidak ada transaksi", "error");
            $("#divpayment").hide();
            document.getElementById('fade').style.display = 'none';
        }
        else {

            // $("#divpayment").load("{!! URL::to('/pos/payment') !!}/"+$("#input").val());
            $.ajax({
                url: "{!! url('pos/getpayment') !!}/" + $('#norefnya').val(),
                data: {},
                dataType: "json",
                type: "get",
                success: function (data) {

                    $('#jenis1').val(data[0]["ck1"]);
                    $('#jenis2').val(data[0]["ck2"]);
//                $('#jenis3').val(data[0]["ck3"]);
                    $('#norefnyaaa').val(data[0]["norefnya"]);
                    $('#divpayment').load("{!! URL::to('/pos/payment') !!}/" + $('#input').val() + "/" + $('#jenis1').val() + "/" + $('#jenis2').val() + "/" + $('#norefnyaaa').val());
                }
            });
        }


    }

});

function lightbox_open(){
    document.getElementById('light').style.display='block';
    document.getElementById('fade').style.display='block';
}
function lightbox_open1(){
    document.getElementById('light1').style.display='block';
    document.getElementById('fade1').style.display='block';
}
function lightbox_open2(){
    document.getElementById('light2').style.display='block';
    document.getElementById('fade2').style.display='block';
}
function lightbox_open3(){
    document.getElementById('light3').style.display='block';
    document.getElementById('fade3').style.display='block';
}
function lightbox_open4(){
    document.getElementById('light4').style.display='block';
    document.getElementById('fade4').style.display='block';
}
function lightbox_open5(){
    document.getElementById('light5').style.display='block';
    document.getElementById('fade5').style.display='block';
}
function lightbox_close(){
    document.getElementById('light').style.display='none';
    document.getElementById('fade').style.display='none';
}
function lightbox_close2(){
    document.getElementById('light2').style.display='none';
    document.getElementById('fade2').style.display='none';
}

$("#payment").click(function(){

    var total = $('#input').val();

    if(total == 0)
    {
        sweetAlert("Oops...", "Tidak ada transaksi", "error");
        document.getElementById('fade').style.display = 'none';
        $("#divpayment").hide();

    }
    else
    {

        // $("#divpayment").load("{!! URL::to('/pos/payment') !!}/"+$("#input").val());
        $.ajax({
            url: "{!! url('pos/getpayment') !!}/" + $('#norefnya').val(),
            data: {},
            dataType: "json",
            type: "get",
            success:function(data)
            {

                $('#jenis1').val(data[0]["ck1"]);
                $('#jenis2').val(data[0]["ck2"]);
//                $('#jenis3').val(data[0]["ck3"]);
                $('#norefnyaaa').val(data[0]["norefnya"]);
                $('#divpayment').load("{!! URL::to('/pos/payment') !!}/" + $('#input').val() + "/" + $('#jenis1').val() + "/" + $('#jenis2').val() + "/" + $('#norefnyaaa').val());
            }
        });
    }

});

$("#ceksaldo").click(function(){


    $("#divceksaldo").load("{!! URL::to('/pos/ceksaldo') !!}/");


});

$("#btnretur").click(function(){

    var total = $('#input').val();

    if (total==0) {
        $("#divretur").load("{!! URL::to('/pos/cekretur') !!}/");
    }
    else
    {
        $("#divretur").hide();
        document.getElementById('fade3').style.display='none';
    }


});





$("#btnesc").click(function(){
    var rolenya = $('#rolenya').val();

    if (rolenya==4) {


        location.href="{!! url('logout') !!}";
    }
    else
    {
        location.href="{!! url('pos/index') !!}";
    }

});
$("#buttonnya").click(function(){


    location.href="{!! url('pos/index') !!}";

});

$("#divesc").click(function(){

    var rolenya = $('#rolenya').val();

    if (rolenya==4) {


        location.href="{!! url('logout') !!}";
    }
    else
    {
        location.href="{!! url('pos/index') !!}";
    }

});

$('#btngantiqty').on('click', function () {

    var total = $('#input').val();

    if(total == 0)
    {
        return false;
    }
    else
    {

        $.ajax({
            url: "{!! url('pos/penjualan/edit') !!}/" + $("#Eid").val() +  "/" + $('#Eqty').val(),
            data: {},
            dataType: "json",
            type: "get",
            success:function(data)
            {
                location.reload();
                $('#Eqty').val("0");
            }

        });
    }

});

var i = 0;


function buttonClick(id) {

    $.ajax({
        url: "{!! url('pos/edit/qty/tambah') !!}/" + id,
        data: {},
        dataType: "json",
        type: "get",
        success:function(data)
        {
            location.reload();
        }

    });

}
function buttonClick2(id)
{
    if(document.getElementById('Eqty').value < 2)
    {

    }
    else
    {
        $.ajax({
            url: "{!! url('pos/edit/qty/kurang') !!}/" + id,
            data: {},
            dataType: "json",
            type: "get",
            success:function(data)
            {

                location.reload();
            }

        });
    }


}

$("#void").click(function(){

    var rolenya = $('#rolenya').val();

    if (rolenya==4)
    {
        $('#divvoid').load("{!! URL::to('/pos/supervisor/permission') !!}/");
    }
    else
    {

        $("#divvoid").hide();
        document.getElementById('fade4').style.display='none';

        swal({
            title: "Apa anda yakin ingin membatalkan transaksi ? ",
            text: "Transaksi akan dibatalkan bila di klik",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',   cancelButtonColor: '#d33',
            confirmButtonText: "Yes",
            closeOnConfirm: false
        }).then(function() {
            swal("", "Transaksi berhasil dibatalkan", "success");
            location.href =  "{{ url('pos/void') }}";
        });

    }






});


$("#hold").click(function()
{

    var total = $('#input').val();
    var norefff = $('#norefnya').val();

    if (total==0)
    {

        location.href="{{url('pos/tahan')}}";

    }
    else
    {

        swal({
            title: "Apa anda yakin ingin menahan transaksi ? ",
            text: "Transaksi akan ditahan bila di klik",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',   cancelButtonColor: '#d33',
            confirmButtonText: "Yes",
            closeOnConfirm: true
        }).then(function() {
            swal("", "Transaksi berhasil ditahan", "success");
            location.href =  "{{ url('pos/penjual/hod') }}" + "/" + norefff;
        });


    }

});

$("#carikode").click(function()

{

    var norefff = $('#barcode').val();

    if (norefff=="")
    {

        location.href=" {{ url('pos/penjual/dataproduk') }}";

    }
    else
    {
        location.href =  "{{ url('pos/penjualan') }}" + "/" + norefff;
    }

});

