<!DOCTYPE html>
<html>
<head>
        <script language="JavaScript">

            <!--
            // please keep these lines on when you copy the source
            // made by: Nicolas - http://www.javascript-page.com

            var clockID = 0;

            function StartClock() {
                clockID = setTimeout("KillClock()", 100);
            }

            function KillClock() {
                if(clockID) {
                    clearTimeout(clockID);
                    window.print();
                    history.back(-1);
                    clockID  = 0;
                }
            }
            $(document).ready(function() {
                UpdateClock();
                StartClock();
                KillClock();
            });

            //-->

        </script>

        <style type="text/css">
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
                font-size:8pt;
            }
            th, td {
                padding: 5px;
            }
            th {
                border-bottom: 0px; 
                vertical-align: middle;
            }
        </style>
	
    <title>Tabungan Transaksi</title>
</head>


<body class="metro" onload="StartClock()" onunload="KillClock()">
    <header>
        <div style="text-align: center">
            <p><b>PT. Koperasi Nesinak <br>
            Tabungan Transaksi</b></p>
        </div>
    </header>
    <br>
	<table width="100%">
        <thead>
             <tr>
                 <th>No.</th>
                 <th>Kode</th>
                 <th>Tipe</th>
                 <th>Saldo Awal</th>
                 <th>Debet</th>
                 <th>Kredit</th>
                 <th>Nominal</th>
             </tr>
        </thead>
        <tbody>
            <?php $i =1; ?>
            @foreach($tabungan as $row)
             <tr>
                <td><center>{!! $i++ !!}</center></td>
                <td>{!! $row->kode !!}</td>
                <td>{!! $row->tipe !!}</td>
                <td>Rp.{!! $row->saldo_awal !!}</td>
                <td>Rp.{!! $row->debet !!}</td>
                <td>Rp.{!! $row->kredit !!}</td>
                <td>Rp.{!! $row->nominal !!}</td>
             </tr>   
             @endforeach
        </tbody>
    </table>
    <br>
    <div style="text-align: right">
        <?php date_default_timezone_set('Asia/Jakarta'); ?>     {{date('r')}}
    </div>


</body>
</html>
