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

<?php $profil = \App\Model\Pengaturan\Profil::findOrNew(1);?>
<body class="metro" onload="StartClock()" onunload="KillClock()">
    <header>
            <img src="{{ public_path('foto/profil/'.$profil->foto) }}" alt="" width="10%" style="float: left">
            <p style="position:absolute;">PT. Koperasi Nesinak <br>Data Akun Perkiraan</p>
    </header>
    <hr>
    <br>
	<table width="100%">
        <thead>
             <tr>
                 <th>No.</th>
                 <th>Kode Akun</th>
                 <th>Nama Akun</th>
                 <th>Kelompok</th>
                 <th>Tanggal Pembuatan</th>
             </tr>
        </thead>
        <tbody>
            <?php $i =1; ?>
            @foreach($perkiraan as $row)
             <tr>
                <td><center>{!! $i++ !!}</center></td>
                <td>{!! $row->kode_akun !!}</td>
                <td>{!! $row->nama_akun !!}</td>
                <td>{!! $kelompok !!}</td>
                <td>{!! $row->created_at !!}</td>
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
