@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li class="active">Dashboard</li>
    </ol>
<section class="layout">

</section>
    <section class="panel" style="color: #000000">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12 mb25">
                    <h5><b>Customer per bulan</b></h5>
                    <div class="category2 chart"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="panel" style="color: #475264">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <h5><b>Laba Rugi Penjualan POS</b></h5>
                    <div class="flot-pie chart mt25"></div>
                </div>
                <div class="col-sm-6">
                    <h5><b>Pendapatan 3 Tahun Terakhir</b></h5>
                    <div class="flot-pie3 chart mt25"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="panel" style="color: #475264">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12 mb25">
                    <h5><b>Pinjaman per bulan</b></h5>
                    <div class="category chart"></div>
                </div>

                    <div class="col-sm-6">
                        <h5><b>Kolektibilitas Pinjaman</b></h5>
                        <div id="status" class="chart"></div>
                    </div>
                    <div class="col-sm-6">
                        <h5><b>Satus Pinjaman</b></h5>
                        <div class="flot-pie2 chart mt25"></div>
                    </div>
            </div>
        </div>
    </section>



    <script>

        var categoryData = [
            ["Jan", {{ $Pinjan or 0 }} + 100],
            ["Feb", {{ $Pinfeb or 0 }} + 100],
            ["Mar", {{ $Pinmar or 0 }} + 50],
            ["Apr", {{ $Pinapr or 0 }} + 100],
            ["May", {{ $Pinmay or 0 }} + 50],
            ["Jun", {{ $Pinjun or 0 }} + 50],
            ["Jul", {{ $Pinjul or 0 }} + 200],
            ["Aug", {{ $Pinaug or 0 }} + 500],
            ["Sep", {{ $Pinsep or 0 }} + 250],
            ["Oct", {{ $Pinoct or 0 }} + 250],
            ["Nov", {{ $Pinnov or 0 }} + 200],
            ["Dec", {{ $Pindec or 0 }} + 100]
        ];

        var categoryData2 = [
            ["Jan", {{ $CSjan or 0 }}],
            ["Feb", {{ $CSfeb or 0 }}],
            ["Mar", {{ $CSmar or 0 }}],
            ["Apr", {{ $CSapr or 0 }}],
            ["May", {{ $CSmay or 0 }}],
            ["Jun", {{ $CSjun or 0 }}],
            ["Jul", {{ $CSjul or 0 }}],
            ["Aug", {{ $CSaug or 0 }}],
            ["Sep", {{ $CSsep or 0 }}],
            ["Oct", {{ $CSoct or 0 }}],
            ["Nov", {{ $CSnov or 0 }}],
            ["Dec", {{ $CSdec or 0 }}]
        ];


        var browserData=[
//            {label:"CASH",data:15,color:"#14a13d"},
//            {label:"Safari",data:14,color:"#767f96"},
//            {label:"Chrome",data:34,color:"#697289"},
            {label:"Laba",data:13,color:"#9b2e2f"},
            {label:"Rugi",data:24,color:"#758092"}
        ];

        var browserData2=[
            {label:"PROSES",data:[{{$PinR}}],color:"#14a13d"},
//            {label:"Safari",data:14,color:"#767f96"},
//            {label:"Chrome",data:34,color:"#697289"},
            {label:"Belum Realisasi",data:[{{$PinW}}],color:"#9b2e2f"},
            {label:"LUNAS",data:[{{$PinL}}],color:"#758092"}
        ];

        var browserData3=[
            {label:"Th 2015",data:20,color:"#14a13d"},
//            {label:"Safari",data:14,color:"#767f96"},
//            {label:"Chrome",data:34,color:"#697289"},
            {label:"Th 2014",data:83,color:"#9b2e2f"},
            {label:"Th 2013",data:14,color:"#758092"}
        ];

        var statusData = [
            {data: [[0, {{ $PinK1 }} + 100]], color: "#1582dc"}, //pending
            {data: [[1, {{ $PinK2 }} + 50]], color: "#15db81"}, //progress
            {data: [[2, {{ $PinK3 }} + 50]], color: "#daac16"}, //reject
            {data: [[3, {{ $PinK4 }} + 50]], color: "#da3e16"}, //reject
            {data: [[4, {{ $PinK5 }} + 100]], color: "#000000"} //complete
        ];


        $.plot(".category", [categoryData],
                {
                    colors: ['#24ACE5'],
                    series: {
                        bars: {
                            show: true, barWidth: 0.5, align: 'center', fill: 1,
                        },
                        shadowSize: 0
                    },
                    grid: {
                        color: '#c2c2c2', borderColor: '#f0f0f0', borderWidth: 1
                    },
                    xaxis: {
                        mode: "categories", tickLength: 0
                    }
                }
        );

        $.plot(".category2", [categoryData2],
                {
                    colors: ['#24ACE5'],
                    series: {
                        bars: {
                            show: true, barWidth: 0.5, align: 'center', fill: 1,
                        },
                        shadowSize: 0
                    },
                    grid: {
                        color: '#c2c2c2', borderColor: '#f0f0f0', borderWidth: 1
                    },
                    xaxis: {
                        mode: "categories", tickLength: 0
                    }
                }
        );

        $.plot($(".flot-pie"), browserData,
                {
                    series: {
                        pie: {
                            show: true,
                        }
                    },
                    legend: {
                        show: false
                    },
                    grid: {
                        hoverable: true
                    },
                    stroke: {
                        width: 0
                    }
                }
        );

        $.plot($(".flot-pie2"), browserData2,
                {
                    series: {
                        pie: {
                            show: true,
                        }
                    },
                    legend: {
                        show: false
                    },
                    grid: {
                        hoverable: true
                    },
                    stroke: {
                        width: 0
                    }
                }
        );

        $.plot($(".flot-pie3"), browserData3,
                {
                    series: {
                        pie: {
                            show: true,
                        }
                    },
                    legend: {
                        show: false
                    },
                    grid: {
                        hoverable: true
                    },
                    stroke: {
                        width: 0
                    }
                }
        );

        $.plot("#status", statusData, {
            series: {
                bars: {
                    show: true,
                    barWidth: 0.3,
                    align: "center",
                    lineWidth: 0,
                    fill: 100
                }
            },
            grid: {
                color: '#c2c2c2', borderColor: '#f0f0f0', borderWidth: 1
            },
            xaxis: {
                ticks: [[0, "Lancar"], [1, "Dalam Perhatian Khusus"], [2, "Kurang Lancar"], [3, "Diragukan"], [4, "Macet"]],
                tickLength: 0
            }
        });

    </script>
@stop
