<!doctype html>
<html class="no-js" lang="">

<!-- Mirrored from sublime.nyasha.me/admin/horizontal_menu.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 19 Mar 2015 03:35:58 GMT -->
<head>
    @include('templates.head')
</head>
<style>
    /* Paste this css to your style sheet file or under head tag */
    /* This only works with JavaScript,
    if it's not present, don't show loader */
    .no-js #loader { display: none;  }
    .js #loader { display: block; position: absolute; left: 100px; top: 0; }
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        background:#000;opacity:0.4;filter:alpha(opacity=40);
        z-index: 9999;
        background: url({{ asset('assets/loader-64x/712.gif') }}) center no-repeat #000;
    }
</style>

<style type="text/css">
    option.red {background-color: #ffcccc;}

    #slideout {
        background: #fff;
        box-shadow: 0 0 5px rgba(0,0,0,.3);
        color: #333;
        position: fixed;
        top: 12%;
        left: 100%;
        width: 25%;
        height: 85%;
        -webkit-transition-duration: 0.3s;
        -moz-transition-duration: 0.3s;
        -o-transition-duration: 0.3s;
        transition-duration: 0.3s;
    }
    #slideout form {
        display: block;
        padding: 20px;
    }
    #slideout textarea {
        display:block;
        height: 100px;
        margin-bottom: 6px;
        width: 250px;
    }
    #slideout.on {
        left: 75%;
    }

</style>
<script>
    $(window).load(function() {
        $(".se-pre-con").fadeOut("fast");;
    });

    function FunctionLoading() {
        $(".se-pre-con").fadeIn("slow");
    };

    function EndLoading() {
        $(".se-pre-con").fadeOut("fast");
    }
</script>

<body>
<div class="se-pre-con"></div>
{!! \developerpratika\Toastr\Facades\Toastr::render() !!}

<div class="app horizontal-layout">

@include('templates.menu')

    <section class="layout">

        <section class="main-content">

            <div class="content-wrap">

                <div class="wrapper">

                    @yield('content')

                </div>

            </div>

            <a class="exit-offscreen"></a>
        </section>

    </section>
</div>

</body>
@include('templates.foot')


<!-- Mirrored from sublime.nyasha.me/admin/horizontal_menu.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 19 Mar 2015 03:35:58 GMT -->
</html>
