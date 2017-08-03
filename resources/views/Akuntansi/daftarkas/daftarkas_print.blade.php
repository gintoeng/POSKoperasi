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
            Buku Besar</b></p>
        </div>
    </header>
    <br>
	<table width="100%">
        <thead>
                                                        <tr>
                                                            <th class="" rowspan="2">No</th>
                                                            <th class="" rowspan="2">No. Transaksi</th>
                                                            <th class="" rowspan="2">Tanggal</th>
                                                            <th class="" rowspan="2">Status</th>
                                                            <th class="" rowspan="2">Tipe</th>
                                                            <th class="" colspan="2">Perkiraan</th>
                                                            <th class="" rowspan="2">Nominal</th>
                                                            <th class="" rowspan="2">Keterangan</th>
                                                        </tr>
                                                        <tr>
                                                              <th>Kode Akun</th>
                                                              <th>Nama Akun</th>
                                                            </tr>
                                                    </thead>
          <tbody>
                 <?php $i = 1; 
                foreach($JurnalHeader as $JurnalHeaders) {
                $JurnalDetail = App\Model\Akuntansi\JurnalDetail::where('id_header', $JurnalHeaders->id)->get();
                foreach($JurnalDetail as $datadetails) {
                ?>
                <tr>
                    <td>{!!$i++!!}</td>
                     <td>{!! $JurnalHeaders->kode_jurnal !!}</td>
                     <td><?php echo substr($JurnalHeaders['tanggal'], 0,10); ?></td>
                    <td>{!! $JurnalHeaders->status !!}</td>
                     <td>{!! $JurnalHeaders->tipe !!}</td>
                <?php
                    $akun = App\Model\Akuntansi\Perkiraan::find($datadetails->id_akun);
                                                                    ?>
                <td>{!! $akun['kode_akun'] !!}</td>
               <td>{!! $akun['nama_akun'] !!}</td>
               <td>{!! $datadetails->nominal !!}</td>
                <td>{!! $JurnalHeaders->keterangan !!}</td>
              </tr>
             <?php } } ?>
                                                    </tbody>
    </table>
    <br>
    <div style="text-align: right">
        <?php date_default_timezone_set('Asia/Jakarta'); ?>     {{date('r')}}
    </div>


</body>
</html>
