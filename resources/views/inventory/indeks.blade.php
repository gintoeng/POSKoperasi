<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Metro, a sleek, intuitive, and powerful framework for faster and easier web development for Windows Metro Style.">
    <meta name="keywords" content="HTML, CSS, JS, JavaScript, framework, metro, front-end, frontend, web development">
    <meta name="author" content="Sergey Pimenov and Metro UI CSS contributors">

    <link rel='shortcut icon' type='image/x-icon' href='{{ asset ('assets/templateinventory/inventory.ico') }}' />
    <title>Menu Inventory</title>

    <link href="{{ asset('assets/templateinventory/css/metro.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/templateinventory/css/metro-icons.css') }}" rel="stylesheet">
    <!--<link href="../css/metro-responsive.css" rel="stylesheet">-->

    <script src="{{ asset ('assets/templateinventory/js/jquery-2.1.3.min.js') }}"></script>
    <script src="{{ asset ('assets/templateinventory/js/metro.js') }}"></script>

    <script>
           function showDialog(id){
               var dialog = $("#"+id).data('dialog');
               if (!dialog.element.data('opened')) {
                   dialog.open();
               } else {
                   dialog.close();
               }
           }
       </script>

    <style>
        .tile-area-controls {
            position: fixed;
            right: 40px;
            top: 40px;
        }

        .tile-group {
            left: 100px;
        }

        .tile, .tile-small, .tile-sqaure, .tile-wide, .tile-large, .tile-big, .tile-super {
            opacity: 0;
            -webkit-transform: scale(.8);
            transform: scale(.8);
        }

        #charmSettings .button {
            margin: 5px;
        }

        .schemeButtons {
            /*width: 300px;*/
        }

        @media screen and (max-width: 640px) {
            .tile-area {
                overflow-y: scroll;
            }
            .tile-area-controls {
                display: none;
            }
        }

        @media screen and (max-width: 320px) {
            .tile-area {
                overflow-y: scroll;
            }

            .tile-area-controls {
                display: none;
            }

        }
    </style>


    <script>
        (function($) {
            $.StartScreen = function(){
                var plugin = this;
                var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;

                plugin.init = function(){
                    setTilesAreaSize();
                    if (width > 640) addMouseWheel();
                };

                var setTilesAreaSize = function(){
                    var groups = $(".tile-group");
                    var tileAreaWidth = 80;
                    $.each(groups, function(i, t){
                        if (width <= 640) {
                            tileAreaWidth = width;
                        } else {
                            tileAreaWidth += $(t).outerWidth() + 80;
                        }
                    });
                    $(".tile-area").css({
                        width: tileAreaWidth
                    });
                };

                var addMouseWheel = function (){
                    $("body").mousewheel(function(event, delta, deltaX, deltaY){
                        var page = $(document);
                        var scroll_value = delta * 50;
                        page.scrollLeft(page.scrollLeft() - scroll_value);
                        return false;
                    });
                };

                plugin.init();
            }
        })(jQuery);

        $(function(){
            $.StartScreen();

            var tiles = $(".tile, .tile-small, .tile-sqaure, .tile-wide, .tile-large, .tile-big, .tile-super");

            $.each(tiles, function(){
                var tile = $(this);
                setTimeout(function(){
                    tile.css({
                        opacity: 1,
                        "-webkit-transform": "scale(1)",
                        "transform": "scale(1)",
                        "-webkit-transition": ".3s",
                        "transition": ".3s"
                    });
                }, Math.floor(Math.random()*500));
            });

            $(".tile-group").animate({
                left: 0
            });
        });

        function showCharms(id){
            var  charm = $(id).data("charm");
            if (charm.element.data("opened") === true) {
                charm.close();
            } else {
                charm.open();
            }
        }

        function setSearchPlace(el){
            var a = $(el);
            var text = a.text();
            var toggle = a.parents('label').children('.dropdown-toggle');

            toggle.text(text);
        }

        $(function(){
            var current_tile_area_scheme = localStorage.getItem('tile-area-scheme') || "tile-area-scheme-dark";
            $(".tile-area").removeClass (function (index, css) {
                return (css.match (/(^|\s)tile-area-scheme-\S+/g) || []).join(' ');
            }).addClass(current_tile_area_scheme);

            $(".schemeButtons .button").hover(
                    function(){
                        var b = $(this);
                        var scheme = "tile-area-scheme-" +  b.data('scheme');
                        $(".tile-area").removeClass (function (index, css) {
                            return (css.match (/(^|\s)tile-area-scheme-\S+/g) || []).join(' ');
                        }).addClass(scheme);
                    },
                    function(){
                        $(".tile-area").removeClass (function (index, css) {
                            return (css.match (/(^|\s)tile-area-scheme-\S+/g) || []).join(' ');
                        }).addClass(current_tile_area_scheme);
                    }
            );

            $(".schemeButtons .button").on("click", function(){
                var b = $(this);
                var scheme = "tile-area-scheme-" +  b.data('scheme');

                $(".tile-area").removeClass (function (index, css) {
                    return (css.match (/(^|\s)tile-area-scheme-\S+/g) || []).join(' ');
                }).addClass(scheme);

                current_tile_area_scheme = scheme;
                localStorage.setItem('tile-area-scheme', scheme);

                showSettings();
            });
        });

    </script>

</head>
<body style="overflow-y: hidden;">
    <div data-role="charm" id="charmSearch">
        <h1 class="text-light">Search</h1>
        <hr class="thin"/>
        <br />
        <div class="input-control text full-size">
            <label>
                <span class="dropdown-toggle drop-marker-light">Anywhere</span>
                <ul class="d-menu" data-role="dropdown">
                    <li><a onclick="setSearchPlace(this)">Anywhere</a></li>
                    <li><a onclick="setSearchPlace(this)">Options</a></li>
                    <li><a onclick="setSearchPlace(this)">Files</a></li>
                    <li><a onclick="setSearchPlace(this)">Internet</a></li>
                </ul>
            </label>
            <input type="text">
            <button class="button"><span class="mif-search"></span></button>
        </div>
    </div>

    <div data-role="charm" id="charmSettings" data-position="right">
        <h1 class="text-light">Settings</h1>
        <hr class="thin"/>
        <br />
        <div class="schemeButtons">
            <div class="button square-button tile-area-scheme-dark" data-scheme="dark"></div>
            <div class="button square-button tile-area-scheme-darkBrown" data-scheme="darkBrown"></div>
            <div class="button square-button tile-area-scheme-darkCrimson" data-scheme="darkCrimson"></div>
            <div class="button square-button tile-area-scheme-darkViolet" data-scheme="darkViolet"></div>
            <div class="button square-button tile-area-scheme-darkMagenta" data-scheme="darkMagenta"></div>
            <div class="button square-button tile-area-scheme-darkCyan" data-scheme="darkCyan"></div>
            <div class="button square-button tile-area-scheme-darkCobalt" data-scheme="darkCobalt"></div>
            <div class="button square-button tile-area-scheme-darkTeal" data-scheme="darkTeal"></div>
            <div class="button square-button tile-area-scheme-darkEmerald" data-scheme="darkEmerald"></div>
            <div class="button square-button tile-area-scheme-darkGreen" data-scheme="darkGreen"></div>
            <div class="button square-button tile-area-scheme-darkOrange" data-scheme="darkOrange"></div>
            <div class="button square-button tile-area-scheme-darkRed" data-scheme="darkRed"></div>
            <div class="button square-button tile-area-scheme-darkPink" data-scheme="darkPink"></div>
            <div class="button square-button tile-area-scheme-darkIndigo" data-scheme="darkIndigo"></div>
            <div class="button square-button tile-area-scheme-darkBlue" data-scheme="darkBlue"></div>
            <div class="button square-button tile-area-scheme-lightBlue" data-scheme="lightBlue"></div>
            <div class="button square-button tile-area-scheme-lightTeal" data-scheme="lightTeal"></div>
            <div class="button square-button tile-area-scheme-lightOlive" data-scheme="lightOlive"></div>
            <div class="button square-button tile-area-scheme-lightOrange" data-scheme="lightOrange"></div>
            <div class="button square-button tile-area-scheme-lightPink" data-scheme="lightPink"></div>
            <div class="button square-button tile-area-scheme-grayed" data-scheme="grayed"></div>
        </div>
    </div>

    <div class="tile-area tile-area-scheme-dark fg-white" style="height: 100%; max-height: 100% !important;">
        <br><br/>
        <h1 class="tile-area-title">
            <?php $cabang = \App\Model\Master\Cabang::find(\Illuminate\Support\Facades\Auth::user()->cabang);?>
          <img src="{{ asset ('assets/templateinventory/inventory.ico') }}" width="40;"> Menu Utama <font size="6" face="calibri"> ( {{$cabang->nama}} )</font></h1>
        <br>
        <div class="tile-area-controls">
            <button class="square-button bg-transparent fg-white bg-hover-dark no-border" onclick="showCharms('#charmSettings')"><span class="mif-cog"></span></button>
            <a href="{!! url('/login') !!}" class="square-button bg-transparent fg-white bg-hover-dark no-border"><span class="mif-switch"></span></a>
        </div>

        <!-- import&export -->

        <div data-role="dialog" id="dialog" class="padding20" data-close-button="true" data-overlay="true" data-overlay-color="op-dark" data-overlay-click-close="true" data-background="bg-green" data-color="fg-white">
              <h1><span class="mif-file-download"></span>&nbsp;Import Produk</h1>
              <hr style="background-color:#fff;">
              <br>
              <div>

                    <p style="margin-right:5%;"> Pilih File Yang akan di Import   : </p>
                    <img src="{{  asset('assets/templateinventory/images/excel.png')}}" class="icon place-center" style="margin-left:20%;">
                      <div class="input-control file" data-role="input" style="width:100%;">
                                <input type="file">
                                <button class="button warning"><span class="mif-folder fg-white"></span></button>
                      </div>
                      <div class="cell">
                        <button  style="width:100%;" class="button loading-pulse lighten primary"><span class="mif-file-upload"></span>&nbsp;Upload</button>
                      </div>
              </div>

          </div>


        {{--<div class="tile-group double">--}}
            {{--<span class="tile-group-title">Master</span>--}}
            {{--<div class="tile-container">--}}

                {{--<a href="{!! url('/masterproduk') !!}">--}}
                    {{--<div class="tile-wide bg-darkViolet fg-white" data-role="tile">--}}
                        {{--<div class="tile-content iconic">--}}
                            {{--<span class="icon mif-dropbox"></span>--}}
                        {{--</div>--}}
                        {{--<div class="tile-label">Master Produk</div>--}}
                    {{--</div>--}}
                {{--</a>--}}


                {{----}}
        {{--</div>--}}

        {{--</div>--}}


        <div class="tile-group double">
            <span class="tile-group-title">Supplier</span>
            <div class="tile-container">

                <a href="{!! url('inventory/supplier/pembelian') !!}">
                <div class="tile-square bg-darkRed fg-white" data-role="tile">
                    <div class="tile-content iconic">
                        <span class="icon mif-shopping-basket"></span>
                    </div>
                    <div class="tile-label">Pembelian Supplier</div>
                </div>
                </a>

                <a href="{!! url('inventory/supplier/retur') !!}">
                <div class="tile-square bg-darker fg-white" data-role="tile">
                    <div class="tile-content iconic">
                        <span class="icon mif-sync-problem"></span>
                    </div>
                    <div class="tile-label">Retur Supplier</div>
                </div>
                </a>

                <a href="{!! url('inventory/supplier/penerimaan') !!}">
                <div class="tile-wide bg-orange fg-white" data-role="tile">
                    <div class="tile-content iconic">
                        <span class="icon mif-enter"></span>
                    </div>
                    <div class="tile-label">Penerimaan Supplier</div>
                </div>
                </a>

            </div>
        </div>

        <div class="tile-group one">
            <span class="tile-group-title">Cabang</span>
            <div class="tile-container">

                <a href="{!! url('inventory/cabang/pengiriman') !!}">
                    <div class="tile-square bg-emerald fg-white" data-role="tile">
                        <div class="tile-content iconic">
                            <span class="icon mif-mail"></span>
                        </div>
                        <div class="tile-label">Pengiriman Cabang</div>
                    </div>
                </a>

                <a href="{!! url('inventory/cabang/penerimaan') !!}">
                    <div class="tile-square bg-cobalt fg-white" data-role="tile">
                        <div class="tile-content iconic">
                            <span class="icon mif-drafts"></span>
                        </div>
                        <div class="tile-label">Penerimaan Cabang</div>
                    </div>
                </a>

            </div>
        </div>


        <div class="tile-group triple">
            <span class="tile-group-title">Lainnya</span>
            <div class="tile-container">

                {{--<a href="{!! url('inventory/cabang/pindah') !!}">--}}
                    {{--<div class="tile-wide bg-amber fg-white" data-role="tile">--}}
                        {{--<div class="tile-content iconic">--}}
                            {{--<span class="icon mif-move-up"></span>--}}
                        {{--</div>--}}
                        {{--<div class="tile-label">Pindah Cabang</div>--}}
                    {{--</div>--}}
                {{--</a>--}}

                <a href="{!! url('/inventory/cabang/opname') !!}">
                    <div class="tile-wide bg-amber fg-white" data-role="tile">
                    <div class="tile-content iconic">
                         <span class="icon mif-qrcode"></span>
                    </div>
                    <div class="tile-label">Stock Opname</div>
                </div>
                 </a>

                 {{--<a href="{!! url('/masterkonfigurasi') !!}">--}}
                  {{--<div class="tile-square bg-magenta fg-white" data-role="tile">--}}
                      {{--<div class="tile-content iconic">--}}

                          {{--<span class="icon mif-wrench mif-4x"></span>--}}
                      {{--</div>--}}
                      {{--<div class="tile-label">Pengaturan</div>--}}
                  {{--</div>--}}
                  {{--</a>--}}

                 {{--<a href="{!! url('/inventory/import/barang') !!}">--}}
                {{--<div class="tile bg-darkIndigo fg-white" data-role="tile">--}}
                    {{--<div class="tile-content iconic">--}}
                        {{--<span class="icon mif-download"></span>--}}
                    {{--</div>--}}
                    {{--<div class="tile-label">Import Produk</div>--}}
                {{--</div>--}}
                {{--</a>--}}

                <a href="{!! url('/lapbarangmasuk') !!}">
                    <div class="tile-square bg-cyan fg-white" data-role="tile">
                        <div class="tile-content iconic">
                            <span class="icon mif-clipboard"></span>
                        </div>
                        <div class="tile-label">Laporan Barang Masuk</div>
                    </div>
                </a>

                <a href="{!! url('/lapbarangkeluar') !!}">
                    <div class="tile-square bg-yellow fg-white" data-role="tile">
                        <div class="tile-content iconic">
                            <span class="icon mif-truck"></span>
                        </div>
                        <div class="tile-label">Laporan Barang Keluar</div>
                    </div>
                </a>
                <a href="{!! url('/stokminimum') !!}">
                    <div class="tile-square bg-crimson fg-white" data-role="tile">
                        <div class="tile-content iconic">
                            <span class="icon mif-stack"></span>
                        </div>
                        <div class="tile-label">Stok Minimum</div>
                    </div>
                </a>

                <a href="{!! url('/inventory/expired') !!}">
                    <div class="tile-square bg-darkViolet fg-white" data-role="tile">
                        <div class="tile-content iconic">
                            <span class="icon mif-warning"></span>
                        </div>
                        <div class="tile-label">Produk Expired</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- hit.ua -->
    <a href='http://hit.ua/?x=136046' target='_blank'>
        <script language="javascript" type="text/javascript"><!--
        Cd=document;Cr="&"+Math.random();Cp="&s=1";
        Cd.cookie="b=b";if(Cd.cookie)Cp+="&c=1";
        Cp+="&t="+(new Date()).getTimezoneOffset();
        if(self!=top)Cp+="&f=1";
        //--></script>
        <script language="javascript1.1" type="text/javascript"><!--
        if(navigator.javaEnabled())Cp+="&j=1";
        //--></script>
        <script language="javascript1.2" type="text/javascript"><!--
        if(typeof(screen)!='undefined')Cp+="&w="+screen.width+"&h="+
        screen.height+"&d="+(screen.colorDepth?screen.colorDepth:screen.pixelDepth);
        //--></script>
    <!-- / hit.ua -->


</body>
</html>
