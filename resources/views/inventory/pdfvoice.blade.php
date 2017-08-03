<!DOCTYPE html>
<html>
<head>


        </script>

    <title>PDF Invoice</title>
</head>
<style type="text/css">

            .tablenoborder, .thnoborder, .tdnoborder {
                border: none;
                border-collapse: collapse;
                font-size:8pt;
            }

            .tableborder, .thborder, .tdborder {
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


<body class="metro" >
	<div style="text-align: center">
         <header>
         <h1>Koperasi Invoice</h1>
            Telp: 087780998958  Fax: 66543545454 Email: Exclusive@exclusive.co.id Website: Exclusive.com</p>
        </header>
    </div>


    <div class="container">
        <h2 style="text-align: center">Invoice</h2>

		 <div class="tab-content">
            <div class="panel-body">
                <table width="100%" class="tableborder">
                    <thead>
                        <tr>
                            <th class="thborder" style="width:5%;">No</th>
                            <th class="thborder" style="width:50%;">Barcode</th>
                            <th class="thborder">Nama</th>
                            <th class="thborder">Jumlah</th>
                            <th class="thborder">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        ?>
                        @foreach($produk as $value)
                        <tr>
                                <td class="text-center tdborder"><center>{!! $i++ !!}.</center></td>
                                <td class="text-center tdborder">{!! $value->barcode !!}</td>
                                <td class="text-center tdborder"><center>{!!$value->nama!!}</center></td>
                                <td class="text-center tdborder"><center>{!!$value->unit!!}</center></td>
                                <td class="text-center tdborder"><center>{!!$value->created_at!!}</center></td>
                        </tr>
                        @endforeach
                    </tbody>
            </table>
            </div>
    </div>
	</div>
</body>
</html>
