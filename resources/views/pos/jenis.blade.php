<!DOCTYPE html>
<html>
<head>
@include('templates.headerpos')
</head>

  <style>

  body{
  margin:0;
  background-color:#FFF;
}
</style>
<body id="">
<div style="width:22.2%; height:200px; margin-left:0px;auto; background-color:#ecf0f1">

  <div style="width:300px; height:200px; margin:0 auto; position:absolute">

           <a onclick="FunctionLoading()" href="{!!url('/pos/index')!!}"><div id="caption" style="cursor:pointer;height:80px; margin-top:100px;float:left; margin-left:30px; position:absolute;color:#3498db"><img src="{{ url('assets/poscss/imgs/back.png') }}" style="width:40px;height:40px" alt="">  Pengaturan</div></a>



       <div id="pagecaption" style="height:44px; margin-top:0px;float:left; margin-left:12px; position:absolute"> Caption </div>
  </div>

</div>

<!--header-->
<div style="width:100%; height:100%;overflow:auto;  background-color:#FFF">

    <div style="background:#ecf0f1;width:22.2%;height:100%;position:absolute;"></div>
     <a onclick="FunctionLoading()" href="{!! url('pos/master') !!}"><div  style="background:#ecf0f1;position:absolute;width:22%;height:8%;margin-left:0px;margin-top:7%;color:#000;font-size:22px;padding-left:45px;padding-top:10px;position:absolute;cursor:pointer;">Informasi Instansi
    </div></a>
        <a onclick="FunctionLoading()" href="{!! url('pos/master/iklan') !!}"><div style="background:#ecf0f1;position:absolute;width:22%;height:8%;margin-left:0px;margin-top:13%;color:#000;font-size:22px;padding-left:45px;padding-top:10px;position:absolute;cursor:pointer;">Iklan
    </div></a>
     <a onclick="FunctionLoading()" href="{!! url('pos/master/jenis') !!}"><div style="background:#3498db;position:absolute;width:22%;height:8%;margin-left:0px;margin-top:18%;color:#FFF;font-size:22px;padding-left:45px;padding-top:10px;position:absolute;cursor:pointer;">Jenis Transaksi
    </div></a>
    {{--<a onclick="FunctionLoading()" href="{!! url('pos/master/promo') !!}"><div style="background:#ecf0f1;position:absolute;width:22%;height:8%;margin-left:0px;margin-top:23%;color:#000;font-size:22px;padding-left:45px;padding-top:10px;position:absolute;cursor:pointer;">Promo--}}
        {{--</div></a>--}}
    <div style="background:#ecf0f1;position:absolute;width:70%;height:70%;margin-left:26%;margin-top:0;">
    </div>
    <button id="simpan" style="font-size:14px;width:10%;height:4.3%;color:#FFF;background:#3498db;position:absolute;border:none;margin-left:81%;margin-top:28.7%">Simpan</button>

                <table id="table" class="display dataTable table table-hover" cellspacing="0" style="margin-top:15%;margin-left:30%;width:62%;position:relative;background:white;">
                                       <thead>
                                            <tr style="background:#3498db; color: white; font-size:16px;">
                                                <td align="center"><b>Transaksi</b></td>
                                                <td align="center"><b>Aktif</b></td>
                                            </tr>
                                        </thead>

                                        <tbody style="overflow:auto; height: 50px;">
                                            
                                            <tr style="background-color: white; font-size:16px; color:black;">
                                                <td align="center">Cash</td>
                                                <td align="center"><input id="ck1" type="checkbox"  style="cursor:pointer"></td>
                                               </tr>

                                               {{--<tr style="background-color: white; font-size:16px; color:black;">--}}
                                                {{--<td align="center">Auto Debet</td>--}}
                                                {{--<td align="center"><input id="ck2" style="cursor:pointer" type="checkbox"></td>--}}
                                               {{--</tr>--}}

                                               <tr style="background-color: white; font-size:16px; color:black;">
                                                <td align="center">Tunda</td>
                                                <td align="center"><input id="ck2" type="checkbox"  style="cursor:pointer"></td>
                                               </tr>  
                                        </tbody>
                                    </table>
                                    


 </div>
 <input type="hidden" value="{{ $angkanya1 }}" id="input1" style="margin-left:50%;margin-top:20%;">
 <input type="hidden" value="{{ $angkanya2 }}" id="input2" style="margin-left:50%;margin-top:20%;">
 {{--<input type="hidden" value="{{ $angkanya3 }}" id="input3" style="margin-left:50%;margin-top:20%;">--}}

<script>

var cek1 = $('#input1').val();
var cek2 = $('#input2').val();
var cek3 = $('#input3').val();

if (cek1==1)
 {
  $('#ck1').attr('checked','checked');
 } 
if (cek2==1)
 {
  $('#ck2').attr('checked','checked');
 }
//if (cek3==1)
// {
//  $('#ck3').attr('checked','checked');
// }



var nomor = 1;
var angka = 0;

  $('#ck1').change(function() {


    if ($('#ck1').is(':checked'))

    {
        $('#input1').val(nomor);   
    } 
    else 
    {

      $('#input1').val(angka); 
    
    }

  });


    $('#ck2').change(function() {


    if ($('#ck2').is(':checked'))

    {
        $('#input2').val(nomor);   
    } 
    else 
    {

      $('#input2').val(angka); 
    
    }

  });


//      $('#ck3').change(function() {
//
//
//    if ($('#ck3').is(':checked'))
//
//    {
//        $('#input3').val(nomor);
//    }
//    else
//    {
//
//      $('#input3').val(angka);
//
//    }
//
//  });





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

 $('#simpan').on('click', function () {


            $.ajax({
                url: "{!! url('pos/master/jenis/simpan') !!}/" + $('#input1').val() +  "/" + $('#input2').val(),
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                { 
                  swal(
                    'Success!',
                    'Berhasil di simpan!',
                    'success'
                        )
                  location.reload();
                }

            });
          // }
        });

</script>

</body>
</html>
