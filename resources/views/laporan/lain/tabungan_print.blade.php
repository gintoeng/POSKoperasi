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
	
    <title>Data Akun</title>
</head>


<body class="metro" onload="StartClock()" onunload="KillClock()">
    <header>
        <div style="text-align: center">
            <p><b>PT. Koperasi Nesinak <br>
            Tabungan</b></p>
        </div>
    </header>
    <br>
	<table width="100%">
        <thead>
             <tr>
                 <th>No.</th>
                 <th>Nomor Tabungan</th>
                 <th>Nasabah</th>
                 <th>Suku Bunga</th>
                 <th>Setoran Bulanan</th>
                 <th>Jangka Waktu</th>
                 <th>status</th>
                 <th>keterangan</th>
             </tr>
        </thead>
        <tbody>
            <?php $i =1; ?>
            @foreach($tabungan as $row)
             <tr>
                <td><center>{!! $i++ !!}</center></td>
                <td>{!! $row->nomor_tabungan !!}</td>
                <?php 
                        $anggota = App\Model\Master\Anggota::find($row->nasabah);
                ?>
                <td>{!! $anggota['nama'] !!}</td>
                <td>{!! $row->suku_bunga !!}</td>
                <td>Rp.{!! $row->setoran_bulanan !!}</td>
                <td>{!! $row->jangka_waktu !!}</td>
                <td>{!! $row->status !!}</td>
                <td>{!! $row->keterangan !!}</td>
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
