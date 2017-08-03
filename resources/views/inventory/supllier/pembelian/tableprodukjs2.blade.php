
    <div class="container" id="" style="overflow-y: scroll; height:400px;">
        <table class="dataTable bordered" data-searching="true" style="overflow:auto; width:100%; background-color:#fff;">
            <thead>
            <tr>
                <th class="ribbed-cyan fg-white padding10 text-shadow">No</th>
                <th class="ribbed-cyan fg-white padding10 text-shadow">Barcode</th>
                <th class="ribbed-cyan fg-white padding10 text-shadow">Nama Produk</th>
                {{--<th class="ribbed-cyan fg-white padding10 text-shadow">Tanggal</th>--}}
                <th class="ribbed-cyan fg-white padding10 text-shadow">Merk</th>
                <th class="ribbed-cyan fg-white padding10 text-shadow">Stok</th>
                <th class="ribbed-cyan fg-white padding10 text-shadow">Harga Beli</th>
                <th class="ribbed-cyan fg-white padding10 text-shadow">Harga Satuan</th>
                <th class="ribbed-cyan fg-white padding10 text-shadow">QTY</th>
                <th class="ribbed-cyan fg-white padding10 text-shadow" align="center"><input type="checkbox" name="checkAll" id="TableAll" align="center"></th>
            </tr>
            </thead>
            <?php $i = 1; ?>
            <tbody>
            @foreach ($produk as $value)
                <?php $mapping = \App\Model\Master\Mappingbarang::where('id_cabang', \Illuminate\Support\Facades\Auth::user()->cabang)->where('id_produk', $value->id)->first();?>
                <tr>
                    <td>{!! $i++ !!}</td>
                    <td>{!! $value->barcode !!}</td>
                    <td>{!! $value->nama !!}</td>
                    {{--                                        <td>{!! $value->created_at !!}</td>--}}
                    <td>{!! $value->classification !!}</td>
                    @if($mapping == null)
                        <td>0</td>
                    @else
                        <td>{!! $mapping->stok !!}</td>
                    @endif
                    <td>{!! number_format($value->harga_beli, '2') !!}</td>
                    <td><input type="text" onkeyup="validAngka(this)" name="harga{{$value->id}}"></td>
                    <td><input type="number" style="width:60px;" onkeyup="validAngka(this)" min="1" value="1" name="qty{{$value->id}}"></td>
                    <td><input type="checkbox" placeholder="" name="cbpilih[{{$value->id}}]"/></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>



<script>
    function validAngka(a)
    {
        if(!/^[0-9.]+$/.test(a.value))
        {
            a.value = a.value.substring(0,a.value.length-1000);
        }
    }
    $('#TableAll').click(function (e) {
        $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    });
</script>
