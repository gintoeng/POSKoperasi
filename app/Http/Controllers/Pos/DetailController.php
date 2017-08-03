<?php

namespace App\Http\Controllers\Pos;

use Illuminate\Http\Request;
use Carbon;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Pos\Transaksiheader;
use App\Model\Pos\Transaksidetail;
use App\Model\Pos\Transaksisementara;
use App\Model\Master\Anggota;
use App\Model\Master\Cabang;
use App\User;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{


        public function allkasirtoday($cb, $jt)
  {
    $kasirnya = "Semua Kasir";
    $role_kasir = '4';
    $kasir   = User::where('role_id',$role_kasir)->get();
    $today = date('Y-m-d');
    $date     = date('Y-m-d');
    $tanggalnya = $today;
    $tanggalnya2 = "Hari Ini";
    $cabang = Cabang::all();

        if ($cb>0) {
          if ($jt!="test") {
            $detail     = Transaksiheader::where('tanggal', $date)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
            $jumlah     = Transaksiheader::where('tanggal', $date)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
          } else {
            $jumlah     = Transaksiheader::where('tanggal', $date)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
            $detail     = Transaksiheader::where('tanggal', $date)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
          }
        } else {
          if ($jt!="test") {
            $jumlah     = Transaksiheader::where('tanggal', $date)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
            $detail     = Transaksiheader::where('tanggal', $date)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
          } else {
            $jumlah     = Transaksiheader::where('tanggal', $date)->where('status', '!=', 'Hold')->sum('jumlah');
            $detail     = Transaksiheader::where('tanggal', $date)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
          }
        }
    return view('pos.periodik')->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('detail', $detail)->with('kasir', $kasir)->with('jumlah', $jumlah)->with('kasirnya', $kasirnya)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2);

  }



  public function allkasirtoday1()
  {
    $payment = "Payment";
    $tunda = 'Tunda';
    $today    = date('Y-m-d)');
    $jumlah   = Transaksiheader::where('tanggal', $today)->where('status', '!=', 'Hold')->sum('jumlah');

    echo '<div id="total" style="width:100%;text-align:right;font-size:75px;color:black;margin-left:2%;position:absolute;margin-top:-2%">Rp.&nbsp'.number_format($jumlah ,2,",",".").'</div>';


  }


    public function showha2()
  {
    $payment       = "Payment";
    $tunda         = 'Tunda';
    $today         = date('Y-m-d)');
    $paginatenya   = Transaksiheader::where('tanggal', $today)->where('status', '!=', 'Hold')->paginate(8);

     echo '<div id="paginationharian" style="margin-left:28%;top:120px;">'.$paginatenya.'</div>';


  }


    public function allkasirall1()

  {
    $payment = "Payment";
    $tunda = 'Tunda';
    $jumlah   = Transaksiheader::where('status', '!=', 'Hold')->sum('jumlah');
    echo '<div id="total" style="width:100%;text-align:right;font-size:75px;color:black;margin-left:2%;position:absolute;margin-top:-2%">Rp.&nbsp'.number_format($jumlah ,2,",",".").'</div>';


  }
      public function showall1($id)
  {
    $payment = "Payment";
    $tunda = 'Tunda';
    $jumlah   = Transaksiheader::where('kasir', $id)->where('status', '!=', 'Hold')->sum('jumlah');
    echo '<div id="total" style="width:100%;text-align:right;font-size:75px;color:black;margin-left:2%;position:absolute;margin-top:-2%">Rp.&nbsp'.number_format($jumlah ,2,",",".").'</div>';


  }
        public function showrange1($id, $df, $dt)
  {
    $payment = "Payment";
$tunda = 'Tunda';
    $jumlah = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->sum('jumlah');
    echo '<div id="total" style="width:100%;text-align:right;font-size:75px;color:black;margin-left:2%;position:absolute;margin-top:-2%">Rp.&nbsp'.number_format($jumlah ,2,",",".").'</div>';


  }
    public function showtoday1($id)
  {
    $payment = "Payment";
    $tunda = 'Tunda';
    $today    = date('Y-m-d');
    $jumlah   = Transaksiheader::where('kasir', $id)->where('tanggal', $today)->where('status', '!=', 'Hold')->sum('jumlah');

    echo '<div id="total" style="width:100%;text-align:right;font-size:75px;color:black;margin-left:2%;position:absolute;margin-top:-2%">Rp.&nbsp'.number_format($jumlah ,2,",",".").'</div>';


  }

        public function allkasirall($cb, $jt)
  {
    $tanggalnya = "ALL DATE";
    $tanggalnya2 = "ALL DATE";
    $kasirnya  = "Semua Kasir";
    $role_kasir = '4';
    $kasir   = User::where('role_id',$role_kasir)->get();
    $cabang = Cabang::all();

    if ($cb>0) {
      if ($jt!="test") {
        $detail     = Transaksiheader::where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
        $jumlah     = Transaksiheader::where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      } else {
        $jumlah     = Transaksiheader::where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
        $detail     = Transaksiheader::where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
      }
    } else {
      if ($jt!="test") {
        $jumlah     = Transaksiheader::where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
        $detail     = Transaksiheader::where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
      } else {
        $jumlah     = Transaksiheader::where('status', '!=', 'Hold')->sum('jumlah');
        $detail     = Transaksiheader::where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
      }
    }


    return view('pos.periodik')->with('cb', $cb)->with('jt', $jt)->with('cabang', $cabang)->with('detail', $detail)->with('jumlah', $jumlah)->with('kasir', $kasir)->with('tanggalnya', $tanggalnya)->with('kasirnya', $kasirnya)->with('tanggalnya2', $tanggalnya2);

  }
      public function allkasirrange1($df, $dt)
  {
    $payment = "Payment";
$tunda = 'Tunda';
    $jumlah = Transaksiheader::where('tanggal', '>=', $df)->where('status', '!=', 'Hold')->where('tanggal', '<=', $dt)->sum('jumlah');
    echo '<div id="total" style="width:100%;text-align:right;font-size:75px;color:black;margin-left:2%;position:absolute;margin-top:-2%">Rp.&nbsp'.number_format($jumlah ,2,",",".").'</div>';


  }
        public function allkasirrange($df, $dt, $cb, $jt)
  {
    $tanggalnya  = $df;
    $tanggalnya2 = $dt;
    $kasirnya    = "Semua Kasir";
    $role_kasir  = '4';
    $kasir       = User::where('role_id',$role_kasir)->get();
    $cabang      = Cabang::all();

            if ($cb>0) {
              if ($jt!="test") {
                $detail     = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
                $jumlah     = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
              } else {
                $jumlah     = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail     = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
              }
            } else {
              if ($jt!="test") {
                $jumlah     = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail     = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
              } else {
                $jumlah     = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail     = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
              }
            }

    return view('pos.periodik')->with('cabang', $cabang)->with('cb',$cb)->with('jt', $jt)->with('detail', $detail)->with('jumlah', $jumlah)->with('kasir',$kasir)->with('kasirnya', $kasirnya)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2);

  }


      public function kasirall($id)
  {

    $role_kasir = '4';
    $kasir      = User::where('role_id',$role_kasir)->get();
    $jumlah     = Transaksiheader::where('kasir', $id)->where('status', '!=', 'Hold')->sum('jumlah');
    $detail     = Transaksiheader::where('kasir', $id)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);

  }
      public function kasirtoday($id)
  {
    //$jumlah  = Transaksiheader::all()->sum('jumlah')->where('tanggal', $df);
$tunda = 'Tunda';
    $payment = 'Payment';
    $tglkasir = Transaksiheader::where('kasir', $id)->where('status', '!=', 'Hold')->where('tanggal', $today)->orderBy('id','desc')->paginate(8);


    echo '<table id="table"  class="display dataTable table table-hover" cellspacing="0" style="margin-top:0px; margin-left:0px;width:1300px;position:relative;background:white;">';
    echo '<thead>';
    echo '<tr style="background:#3498db; color: white; font-size:16px;">';
    echo '<td align="center">No Ref</td>';
    echo '<td align="center">Tanggal</td>';
    echo '<td align="center">Jumlah</td>';
    echo '<td align="center">Type Pembayaran</td>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody style="overflow:auto; height: 50px;">';
    foreach ($tglkasir as $value) {
    $jml = $value->jumlah;
    echo '<tr style="background-color: white; font-size:18px; color:black;">';
    echo '<td align="center">'.$value->noref.'</td>';
    echo '<td align="center">'.$value->tanggal.'</td>';
    echo '<td align="center"> Rp. '.number_format($jml, 2, ',', '.').'</td>';
    echo '<td align="center">'.$value->type_pembayaran.'</td>';
    echo '</tr>';
  }
  echo '</tbody>';
  echo '</table> ';

  }
      public function kasirrange($id)
  {
    $tunda = 'Tunda';
    //$jumlah  = Transaksiheader::all()->sum('jumlah')->where('tanggal', $df);
   $payment = 'Payment';
   $tglkasir = Transaksiheader::where('kasir', $id)->where('status', '!=', 'Hold')->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->orderBy('id','desc')->paginate(8);


    echo '<table id="table"  class="display dataTable table table-hover" cellspacing="0" style="margin-top:0px; margin-left:0px;width:1300px;position:relative;background:white;">';
    echo '<thead>';
    echo '<tr style="background:#3498db; color: white; font-size:16px;">';
    echo '<td align="center">No Ref</td>';
    echo '<td align="center">Tanggal</td>';
    echo '<td align="center">Jumlah</td>';
    echo '<td align="center">Type Pembayaran</td>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody style="overflow:auto; height: 50px;">';
    foreach ($tglkasir as $value) {
    $jml = $value->jumlah;
    echo '<tr style="background-color: white; font-size:18px; color:black;">';
    echo '<td align="center">'.$value->noref.'</td>';
    echo '<td align="center">'.$value->tanggal.'</td>';
    echo '<td align="center"> Rp. '.number_format($jml, 2, ',', '.').'</td>';
    echo '<td align="center">'.$value->type_pembayaran.'</td>';
    echo '</tr>';
  }
  echo '</tbody>';
  echo '</table> ';

}

  public function showha($df, $cb, $jt)
  {
    $role_kasir = '4';
    $kasir   = User::where('role_id',$role_kasir)->get();
    $tanggalnya = $df;
    $kasirnya = "Semua Kasir";
    $cabang = Cabang::all();

    // dd($jt);

    if ($cb>0) {
      if ($jt!="test") {
        $jumlah     = Transaksiheader::where('tanggal', $df)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
        $detail     = Transaksiheader::where('tanggal', $df)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
      } else {
        $jumlah     = Transaksiheader::where('tanggal', $df)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
        $detail     = Transaksiheader::where('tanggal', $df)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
      }
    } else {
      if ($jt!="test") {
        $jumlah     = Transaksiheader::where('tanggal', $df)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
        $detail     = Transaksiheader::where('tanggal', $df)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
      } else {
        $jumlah     = Transaksiheader::where('tanggal', $df)->where('status', '!=', 'Hold')->sum('jumlah');
        $detail     = Transaksiheader::where('tanggal', $df)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
      }
    }
    // dd($detail);
    return view('pos.kasir')->with('cabang', $cabang)->with('detail', $detail)->with('jumlah', $jumlah)->with('tanggalnya', $tanggalnya)->with('kasir', $kasir)->with('kasirnya', $kasirnya)->with('cb', $cb)->with('jt', $jt);

  }

    public function showha1($df)
  {
    $payment = "Payment";
    $tunda = 'Tunda';
    $jumlah  = Transaksiheader::where('tanggal', $df)->where('status', '!=', 'Hold')->sum('jumlah');
    $tglkasir = Transaksiheader::where('tanggal', $df)->where('status', '!=', 'Hold')->orderBy('id','desc')->get();

    echo '<div id="total" style="width:100%;text-align:right;font-size:75px;color:black;margin-left:2%;position:absolute;margin-top:-2%">Rp.&nbsp'.number_format($jumlah ,2,",",".").'</div>';

  }

      public function show1($id, $df)
  {
    $payment  = "Payment";
    $tunda = 'Tunda';
    $jumlah   = Transaksiheader::where('tanggal', $df)->where('status', '!=', 'Hold')->sum('jumlah');
    $tglkasir = Transaksiheader::where('kasir', $id)->where('status', '!=', 'Hold')->where('tanggal', $df)->orderBy('id','desc')->get();

    echo '<div id="total" style="width:100%;text-align:right;font-size:75px;color:black;margin-left:2%;position:absolute;margin-top:-2%">Rp.&nbsp'.number_format($jumlah ,2,",",".").'</div>';



  }

  public function show($id, $df, $cb, $jt)
  {
    $role_kasir = '4';
    $kasir      = User::where('role_id',$role_kasir)->get();
    $kasirnyaou = User::where('id',$id)->first();
    $kasirnya   = $id;
    $tanggalnya = $df;
    $cabang = Cabang::all();

    if ($cb>0) {
      if ($jt!="test") {
        $jumlah     = Transaksiheader::where('kasir', $id)->where('tanggal', $df)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
        $detail     = Transaksiheader::where('kasir', $id)->where('tanggal', $df)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
      } else {
        $jumlah     = Transaksiheader::where('kasir', $id)->where('tanggal', $df)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
        $detail     = Transaksiheader::where('kasir', $id)->where('tanggal', $df)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
      }
    } else {
      if ($jt!="test") {
        $jumlah     = Transaksiheader::where('kasir', $id)->where('tanggal', $df)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
        $detail     = Transaksiheader::where('kasir', $id)->where('tanggal', $df)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
      } else {
        $jumlah     = Transaksiheader::where('kasir', $id)->where('tanggal', $df)->where('status', '!=', 'Hold')->sum('jumlah');
        $detail     = Transaksiheader::where('kasir', $id)->where('tanggal', $df)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
      }
    }

    return view('pos.kasir')->with('cabang', $cabang)->with('detail', $detail)->with('jumlah', $jumlah)->with('tanggalnya', $tanggalnya)->with('kasir', $kasir)->with('kasirnya', $kasirnya)->with('cb', $cb)->with('jt', $jt);


    }
    public function showtoday($id, $cb, $jt)
  {
    $kasirnya    = $id;
    $role_kasir  = '4';
    $kasir       = User::where('role_id',$role_kasir)->get();
    $today       = date('Y-m-d)');
    $tanggalnya2 = "Hari Ini";
    $tanggalnya  = $today;
    $cabang      = Cabang::all();

        if ($cb>0) {
          if ($jt!="test") {
            $jumlah     = Transaksiheader::where('kasir', $id)->where('tanggal', $today)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
            $detail     = Transaksiheader::where('kasir', $id)->where('tanggal', $today)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
          } else {
            $jumlah     = Transaksiheader::where('kasir', $id)->where('tanggal', $today)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
            $detail     = Transaksiheader::where('kasir', $id)->where('tanggal', $today)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
          }
        } else {
          if ($jt!="test") {
            $jumlah     = Transaksiheader::where('kasir', $id)->where('tanggal', $today)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
            $detail     = Transaksiheader::where('kasir', $id)->where('tanggal', $today)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
          } else {
            $jumlah     = Transaksiheader::where('kasir', $id)->where('tanggal', $today)->where('status', '!=', 'Hold')->sum('jumlah');
            $detail     = Transaksiheader::where('kasir', $id)->where('tanggal', $today)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
          }
        }

    return view('pos.periodik')->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('kasir', $kasir)->with('jumlah', $jumlah)->with('detail', $detail)->with('tanggalnya2', $tanggalnya2)->with('tanggalnya', $tanggalnya)->with('kasirnya', $kasirnya);

  }

    public function showall($id, $cb, $jt)
  {
    $tanggalnya = "ALL DATE";
    $tanggalnya2 = "ALL DATE";
    $kasirnya = $id;
    $role_kasir = '4';
    $kasir   = User::where('role_id',$role_kasir)->get();
    $cabang = Cabang::all();

    if ($cb>0) {
      if ($jt!="test") {
        $jumlah     = Transaksiheader::where('kasir', $id)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
        $detail     = Transaksiheader::where('kasir', $id)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
      } else {
        $jumlah     = Transaksiheader::where('kasir', $id)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
        $detail     = Transaksiheader::where('kasir', $id)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
      }
    } else {
      if ($jt!="test") {
        $jumlah     = Transaksiheader::where('kasir', $id)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
        $detail     = Transaksiheader::where('kasir', $id)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
      } else {
        $jumlah     = Transaksiheader::where('kasir', $id)->where('status', '!=', 'Hold')->sum('jumlah');
        $detail     = Transaksiheader::where('kasir', $id)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
      }
    }


    return view('pos.periodik')->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('kasir', $kasir)->with('jumlah', $jumlah)->with('detail', $detail)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2)->with('kasirnya', $kasirnya);

  }
    public function showrange($id, $df, $dt, $cb, $jt)
  {
    $tanggalnya  = $df;
    $tanggalnya2 = $dt;
    $kasirnya    = $id;
    $role_kasir  = '4';
  $kasir       = User::where('role_id',$role_kasir)->get();
  $cabang = Cabang::all();


      if ($cb>0) {
        if ($jt!="test") {
          $jumlah     = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
          $detail     = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
        } else {
          $jumlah     = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
          $detail     = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
        }
      } else {
        if ($jt!="test") {
          $jumlah     = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
          $detail     = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
        } else {
          $jumlah     = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->sum('jumlah');
          $detail     = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
        }
      }

    return view('pos.periodik')->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('kasir', $kasir)->with('jumlah', $jumlah)->with('detail', $detail)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2)->with('kasirnya', $kasirnya);

  }

  public function kasirharian($id, $df)
  {
     $sim = Transaksiheader::findOrNew($id);

        $data[] = array(
            'no'                  => $sim->no,
            'noref'              => $sim->noref,
            'tanggal'             => $sim->tanggal,
            'jumlah'              => number_format($sim->jumlah, 2, '.', ','),
            'no_kartu'            => $sim->no_kartu,
            'type_pembayaran'     => $sim->type_pembayaran,
            'kasir'               => $sim->kasir,
            'status'              => $sim->status,
            'kategori'            => $sim->kategori
        );

        return json_encode($data);
  }





   public function index()
    {
   $tunda = 'Tunda';
   $payment = "Payment";
   $detail 	= Transaksiheader::where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
   $jumlah  = Transaksiheader::where('status', '!=', 'Hold')->sum('jumlah');
   $today   = date('Y-m-d');
   $tanggalnya = $today;
   $kasirnya = "Semua Kasir";
   $cb = "JKT";
   $jt = "Semua Jenis";
   $role_kasir = '4';
   $kasir   = User::where('role_id',$role_kasir)->get();
   $cabang = Cabang::all();
   return view('pos.kasir')->with('cb', $cb)->with('jt', $jt)->with('cabang', $cabang)->with('detail',$detail)->with('jumlah',$jumlah)->with('today',$today)->with('kasir',$kasir)->with('tanggalnya', $tanggalnya)->with('kasirnya', $kasirnya);

    }
      public function periodik()
    {
   $cb = "JKT";
   $jt = "Semua Jenis";
   $kasirnya = "Semua Kasir";
   $tunda = 'Tunda';
   $payment = "Payment";
   $cabang = Cabang::all();
   $detail  = Transaksiheader::where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
   $jumlah  = Transaksiheader::where('status', '!=', 'Hold')->sum('jumlah');
   $today   = date('Y-m-d');
   $tanggalnya = $today;
   $tanggalnya2 = $today;
   $role_kasir = '4';
   $kasir   = User::where('role_id',$role_kasir)->get();
   return view('pos.periodik')->with('cb', $cb)->with('jt', $jt)->with('cabang', $cabang)->with('detail',$detail)->with('jumlah',$jumlah)->with('today',$today)->with('kasir',$kasir)->with('tanggalnya', $tanggalnya)->with('kasirnya', $kasirnya)->with('tanggalnya2', $tanggalnya2);

    }

       public function kasirtahunan()
    {
   $cb = "JKT";
   $jt = "Semua Jenis";
   $tunda = 'Tunda';
   $kasirnya = "Semua Kasir";
   $payment = "Payment";
   $cabang = Cabang::all();
   $detail  = Transaksiheader::where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
   $jumlah  = Transaksiheader::where('status', '!=', 'Hold')->sum('jumlah');
   $today   = date('Y-m-d');
   $role_kasir = '4';
   $tanggalnya = $today;
   $kasir   = User::where('role_id',$role_kasir)->get();
   return view('pos.kasirtahunan')->with('cb', $cb)->with('jt', $jt)->with('cabang', $cabang)->with('detail',$detail)->with('jumlah',$jumlah)->with('today',$today)->with('kasir',$kasir)->with('tanggalnya', $tanggalnya)->with('kasirnya', $kasirnya);

    }

     public function index1()
    {
   $cb = "JKT";
   $jt = "Semua Jenis";
   $tunda = 'Tunda';
   $payment = "Payment";
   $cabang = Cabang::all();
   $detail 	= Transaksiheader::where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
   $jumlah  = Transaksiheader::where('status', '!=', 'Hold')->sum('jumlah');
   $today   = date('Y-m-d');
   $role_kasir = '4';
   $tanggalnya = $today;
   $kasirnya = "Semua Kasir";
   $kasir   = User::where('role_id',$role_kasir)->get();
   return view('pos.semuakasir')->with('cb', $cb)->with('jt', $jt)->with('cabang', $cabang)->with('detail',$detail)->with('jumlah',$jumlah)->with('today',$today)->with('kasir',$kasir)->with('tanggalnya', $tanggalnya)->with('kasirnya', $kasirnya);
    }

  public function month1($df)

  {
    $tunda      = 'Tunda';
    $payment    = "Payment";
    $jumlah     = Transaksiheader::where('tanggal', 'like', '%-'.$df.'-%')->where('status', '!=', 'Hold')->sum('jumlah');
    $tglkasir   = Transaksiheader::where('kasir', $id)->where('tanggal', 'like', '%-'.$df.'-%')->where('status', $payment)->orWhere('status', $tunda)->orderBy('id','desc')->get();

    echo '<div id="total" style="width:100%;text-align:right;font-size:75px;color:black;margin-left:2%;position:absolute;margin-top:-2%">Rp.&nbsp'.number_format($jumlah ,2,",",".").'</div>';


  }

    public function month($df, $cb, $jt)
    {
    $role_kasir = '4';
    $kasir   = User::where('role_id',$role_kasir)->get();
    $kasirnya   = "Semua Kasir";
    $tanggalnya = $df;
    $cabang = Cabang::all();

        if ($cb>0) {
          if ($jt!="test") {
            $detail     = Transaksiheader::where('tanggal', 'like', '%-'.$df.'-%')->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
            $jumlah     = Transaksiheader::where('tanggal', 'like', '%-'.$df.'-%')->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
          } else {
            $jumlah     = Transaksiheader::where('tanggal', 'like', '%-'.$df.'-%')->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
            $detail     = Transaksiheader::where('tanggal', 'like', '%-'.$df.'-%')->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
          }
        } else {
          if ($jt!="test") {
            $jumlah     = Transaksiheader::where('tanggal', 'like', '%-'.$df.'-%')->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
            $detail     = Transaksiheader::where('tanggal', 'like', '%-'.$df.'-%')->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
          } else {
            $jumlah     = Transaksiheader::where('tanggal', 'like', '%-'.$df.'-%')->where('status', '!=', 'Hold')->sum('jumlah');
            $detail     = Transaksiheader::where('tanggal', 'like', '%-'.$df.'-%')->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
          }
        }

        return view('pos.semuakasir')->with('cabang', $cabang)->with('detail',$detail)->with('kasir', $kasir)->with('jumlah', $jumlah)->with('tanggalnya', $tanggalnya)->with('kasirnya', $kasirnya)->with('cb', $cb)->with('jt', $jt);

    }


        public function allmonth($id, $df, $cb, $jt)
    {
    $role_kasir = '4';
    $kasir   = User::where('role_id',$role_kasir)->get();
    $kasirnya   = $id;
    $tanggalnya = $df;
    $cabang = Cabang::all();

    if ($cb>0) {
      if ($jt!="test") {
        $detail     = Transaksiheader::where('kasir', $id)->where('tanggal', 'like', '%-'.$df.'-%')->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
        $jumlah     = Transaksiheader::where('kasir', $id)->where('tanggal', 'like', '%-'.$df.'-%')->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      } else {
        $jumlah     = Transaksiheader::where('kasir', $id)->where('tanggal', 'like', '%-'.$df.'-%')->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
        $detail     = Transaksiheader::where('kasir', $id)->where('tanggal', 'like', '%-'.$df.'-%')->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
      }
    } else {
      if ($jt!="test") {
        $jumlah     = Transaksiheader::where('kasir', $id)->where('tanggal', 'like', '%-'.$df.'-%')->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
        $detail     = Transaksiheader::where('kasir', $id)->where('tanggal', 'like', '%-'.$df.'-%')->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
      } else {
        $jumlah     = Transaksiheader::where('kasir', $id)->where('tanggal', 'like', '%-'.$df.'-%')->where('status', '!=', 'Hold')->sum('jumlah');
        $detail     = Transaksiheader::where('kasir', $id)->where('tanggal', 'like', '%-'.$df.'-%')->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
      }
    }

   return view('pos.semuakasir')->with('cabang', $cabang)->with('detail',$detail)->with('kasir', $kasir)->with('jumlah', $jumlah)->with('tanggalnya', $tanggalnya)->with('kasirnya', $kasirnya)->with('cb', $cb)->with('jt', $jt);


    }

    public function allmonth1($id, $df)
  {
    $tunda = 'Tunda';
    $payment    = "Payment";
    $jumlah     = Transaksiheader::where('tanggal', 'like', '%-'.$df.'-%')->where('status', '!=', 'Hold')->sum('jumlah');
    $tglkasir   = Transaksiheader::where('kasir', $id)->where('tanggal', 'like', '%-'.$df.'-%')->where('status', '!=', 'Hold')->orderBy('id','desc')->get();

    echo '<div id="total" style="width:100%;text-align:right;font-size:75px;color:black;margin-left:2%;position:absolute;margin-top:-2%">Rp.&nbsp'.number_format($jumlah ,2,",",".").'</div>';

  }

    public function allyear1($id, $df)
  {
    $tunda = 'Tunda';
    $payment = "Payment";
    $jumlah  = Transaksiheader::where('kasir', $id)->where('status', '!=', 'Hold')->where('tanggal', 'like', $df.'-%')->sum('jumlah');
    $tglkasir   = Transaksiheader::where('kasir', $id)->where('status', '!=', 'Hold')->where('tanggal', 'like', $df.'-%')->orderBy('id','desc')->get();

   echo '<div id="total" style="width:100%;text-align:right;font-size:75px;color:black;margin-left:2%;position:absolute;margin-top:-2%">Rp.&nbsp'.number_format($jumlah ,2,",",".").'</div>';

  }

    public function year1($df)
  {
    $tunda = 'Tunda';
    $payment = "Payment";
    $jumlah  = Transaksiheader::where('tanggal', 'like', $df.'-%')->where('status', '!=', 'Hold')->sum('jumlah');
    $tglkasir   = Transaksiheader::where('tanggal', 'like', $df.'-%')->where('status', '!=', 'Hold')->orderBy('id','desc')->get();

    echo '<div id="total" style="width:100%;text-align:right;font-size:75px;color:black;margin-left:2%;position:absolute;margin-top:-2%">Rp.&nbsp'.number_format($jumlah ,2,",",".").'</div>';

  }

  public function year($df, $cb, $jt)
    {

    $kasirnya   = "Semua Kasir";
    $tanggalnya = $df;
    $role_kasir = '4';
    $kasir      = User::where('role_id',$role_kasir)->get();
    $cabang     = Cabang::all();

    if ($cb>0) {
      if ($jt!="test") {
        $detail     = Transaksiheader::where('tanggal', 'like', $df.'-%')->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
        $jumlah     = Transaksiheader::where('tanggal', 'like', $df.'-%')->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      } else {
        $jumlah     = Transaksiheader::where('tanggal', 'like', $df.'-%')->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
        $detail     = Transaksiheader::where('tanggal', 'like', $df.'-%')->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
      }
    } else {
      if ($jt!="test") {
        $jumlah     = Transaksiheader::where('tanggal', 'like', $df.'-%')->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
        $detail     = Transaksiheader::where('tanggal', 'like', $df.'-%')->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
      } else {
        $jumlah     = Transaksiheader::where('tanggal', 'like', $df.'-%')->where('status', '!=', 'Hold')->sum('jumlah');
        $detail     = Transaksiheader::where('tanggal', 'like', $df.'-%')->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
      }
    }

    return view('pos.kasirtahunan')->with('cb', $cb)->with('jt', $jt)->with('cabang', $cabang)->with('kasir', $kasir)->with('detail', $detail)->with('jumlah', $jumlah)->with('tanggalnya', $tanggalnya)->with('kasirnya', $kasirnya);
    }

    public function allyear($id, $df, $cb, $jt)
    {
    $kasirnya   = $id;
    $tanggalnya = $df;
    $role_kasir = '4';
    $kasir      = User::where('role_id',$role_kasir)->get();
    $cabang     = Cabang::all();



        if ($cb>0) {
          if ($jt!="test") {
            $detail     = Transaksiheader::where('kasir', $id)->where('tanggal', 'like', $df.'-%')->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
            $jumlah     = Transaksiheader::where('kasir', $id)->where('tanggal', 'like', $df.'-%')->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
          } else {
            $jumlah     = Transaksiheader::where('kasir', $id)->where('tanggal', 'like', $df.'-%')->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
            $detail     = Transaksiheader::where('kasir', $id)->where('tanggal', 'like', $df.'-%')->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
          }
        } else {
          if ($jt!="test") {
            $jumlah     = Transaksiheader::where('kasir', $id)->where('tanggal', 'like', $df.'-%')->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
            $detail     = Transaksiheader::where('kasir', $id)->where('tanggal', 'like', $df.'-%')->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
          } else {
            $jumlah     = Transaksiheader::where('kasir', $id)->where('tanggal', 'like', $df.'-%')->where('status', '!=', 'Hold')->sum('jumlah');
            $detail     = Transaksiheader::where('kasir', $id)->where('tanggal', 'like', $df.'-%')->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
          }
        }

    return view('pos.kasirtahunan')->with('cb', $cb)->with('jt', $jt)->with('cabang', $cabang)->with('kasir', $kasir)->with('detail', $detail)->with('jumlah', $jumlah)->with('tanggalnya', $tanggalnya)->with('kasirnya', $kasirnya);
    }
}
