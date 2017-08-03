<?php

date_default_timezone_set('Asia/Jakarta');
$jumHari = date('t');
$simp = \App\Model\Simpanan\Simpanan::findOrNew($id);

$sistembunga = $simp->pengaturanid->sistem_bunga;
$sbunga = $simp->pengaturanid->suku_bunga;
$minbunga = $simp->pengaturanid->saldo_minimum_bunga;

$akarsaldo = $saldonya;;

$cektr = \App\Model\Simpanan\Transaksi::where('id_simpanan', $id)->where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('tipe', 'SETOR')->where('kredit' , $simp->setoran_bulanan)->first();

if ($akarsaldo >= $minbunga) {
    if ($sistembunga == "1") {
        $transaksi = \App\Model\Simpanan\Transaksi::where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('id_simpanan', $id)->min('saldo_akhir');
        if ($cektr == null) {
            if ($simp->setoran_bulanan < $transaksi) {
                $saldo = $simp->setoran_bulanan;
            } else {
                $saldo = $transaksi;
            }
        } else {
            $saldo = $transaksi;
        }
        $bunga = $saldo * $sbunga / 100 * $jumHari / 365;
    } else if ($sistembunga == "2") {
        $i = 0;
        $t = 0;
        $transaksi = \App\Model\Simpanan\Transaksi::where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('id_simpanan', $id)->get();
        $transaksi2 = \App\Model\Simpanan\Transaksi::where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('id_simpanan', $id)->orderBy('id', 'desc')->first();
        $trcount = \App\Model\Simpanan\Transaksi::where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('id_simpanan', $id)->count();
        foreach ($transaksi as $ts) {
            $a = $i++;
            $b = $a + 1;

            if ($b == $trcount) {
                $ddt = date('Y-m-t');
                $hari = ((abs(strtotime($transaksi[$a]['tanggal']) - strtotime($ddt))) / (60 * 60 * 24));
                $nominal = $transaksi[$a]['saldo_akhir'];
                $total = $nominal * $hari;
            } else {
                $hari = ((abs(strtotime($transaksi[$a]['tanggal']) - strtotime($transaksi[$b]['tanggal']))) / (60 * 60 * 24));
                $nominal = $transaksi[$a]['saldo_akhir'];
                $total = $nominal * $hari;
            }
            $t += $total;
        }
        if ($cektr == null) {
            $ddt = date('Y-m-t');
            $harinya = ((abs(strtotime($transaksi2->tanggal) - strtotime($ddt))) / (60 * 60 * 24));
            $saldo = ($t / $jumHari) + ($simp->setoran_bulanan * $harinya);
        } else {
            $saldo = $t / $jumHari;
        }
        $bunga = $saldo * $sbunga / 100 * $jumHari / 365;
    } else {
        $i = 0;
        $y = 0;
        $z = 0;
        $transaksi = \App\Model\Simpanan\Transaksi::where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('id_simpanan', $id)->get();
        $transaksi2 = \App\Model\Simpanan\Transaksi::where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('id_simpanan', $id)->orderBy('id', 'desc')->first();
        $trcount = \App\Model\Simpanan\Transaksi::where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('id_simpanan', $id)->count();
        foreach ($transaksi as $gg) {
            $a = $i++;
            $b = $a + 1;

            if ($b == $trcount) {
                $ddt = date('Y-m-t');
                $hari = ((abs(strtotime($transaksi[$a]['tanggal']) - strtotime($ddt))) / (60 * 60 * 24));
                $nominal = $transaksi[$a]['saldo_akhir'];
                $total = $nominal * $simp->suku_bunga / 100 * ($hari / 365);
            } else {
                $hari = ((abs(strtotime($transaksi[$a]['tanggal']) - strtotime($transaksi[$b]['tanggal']))) / (60 * 60 * 24));
                $day = $transaksi[$a]['tanggal'];
                $day2 = $transaksi[$b]['tanggal'];
                $nominal = $transaksi[$a]['saldo_akhir'];
                $total = $nominal * $simp->suku_bunga / 100 * ($hari / 365);
            }
            $y += $total;
            $z += $nominal;
        }
        $saldo = $z;
        if ($cektr == null) {
            $ddt = date('Y-m-t');
            $harinya = ((abs(strtotime($transaksi2->tanggal) - strtotime($ddt))) / (60 * 60 * 24));
            $bunga = $y + ($simp->setoran_bulanan * $simp->suku_bunga / 100 * ($harinya / 365));
        } else {
            $bunga = $y;
        }
    }
    $bunganya = $bunga;
} else {
    $bunganya = 0;
}

$sldnya = $asaldo + $setr + $bunganya;
echo '<td align="right">' . number_format($bunganya, 2, '.', ',') . '</td>';
echo '<td class="text-right">' . number_format($sldnya, 2, '.', ',') . '</td>';
$asaldo = $sldnya; $saldonya2 = $sldnya; $saldor2 = $sldnya;

//echo '<td align="right">' . number_format($sldnya, 2, '.', ',') . '</td>';

