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
            Pembagian SHU Anggota</b></p>
        </div>
    </header>
    <br>
	<table width="100%">
        <thead>
                                    <tr>
                                        <th class="">No</th>
                                        <th class="">Nama</th>
                                        <th class="">NIK</th>
                                        <th class="">Sim.Pokok/Sim.Wajib</th>
                                        <th class="">Jasa Belanja</th>
                                        <th class="">SHU Jasa Anggota</th>
                                        <th class="">SHU Jasa Usaha</th>
                                        <th class="">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; 
                                    foreach($anggota as $anggotas) {
                                     $jasa_usaha = App\Model\Akuntansi\Tabungan::where('nasabah', $anggotas->id)->sum('setoran_bulanan'); 
                                            $shu_jasa_anggota = $simpananwajib * $perrupiah_jasamodal;
                                            $shu_jasa_usaha = $jasa_usaha * $perrupiah_jasausaha;
                                            $total = $shu_jasa_anggota + $shu_jasa_usaha;
                                    
                                    ?>
                                    <tr>
                                        <td class="text-center">{!! $i++ !!}</td>
                                        <td>{!! $anggotas->nama !!}</td>
                                        <td>{!! $anggotas->nik !!}</td>
                                        <td align="right">Rp.{!! $simpananwajib !!}</td>
                                        <td align="right">Rp.{!! $jasa_usaha !!}</td>
                                        <td align="right">Rp.{!! $shu_jasa_anggota !!}</td>
                                        <td align="right">Rp.{!! $shu_jasa_usaha !!}</td>
                                        <td align="right">Rp.{!! $total !!}</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
    </table>
    <br>
    <div style="text-align: right">
        <?php date_default_timezone_set('Asia/Jakarta'); ?>     {{date('r')}}
    </div>


</body>
</html>
