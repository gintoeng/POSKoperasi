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
            POS Transaksi</b></p>
        </div>
    </header>
    <br>
	<table width="100%">
        <thead>
             <tr>
                 <th>No.</th>
                 <th>No Ref</th>
                 <th>Tanggal</th>
                 <th>No Kartu</th>
                 <th>Nama</th>
                 <th>Status</th>
                 <th>Jumlah</th>
             </tr>
        </thead>
        <tbody>
            <?php $i =1; ?>
            @foreach($transaksi as $row)
             <tr>
                <td><center>{!! $i++ !!}</center></td>
                <td>{!! $row->no_ref !!}</td>
                <td>{!! $row->tanggal !!}</td>
                <td>{!! $row->no_kartu !!}</td>
                <?php $anggotaterpilih = App\Model\Master\Anggota::where('account_card', $row->no_kartu)->get();
                    foreach ($anggotaterpilih as $rows) {
                        $anggota = App\Model\Master\Anggota::find($rows->id);
                    }
                ?>
                <td>{!! $anggota['nama'] !!}</td>
                <td>{!! $row->status !!}</td>
                <td>Rp.{!! $row->jumlah !!}</td>
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
