<div class="container" id="" style="overflow-y: scroll; height:400px;">
    <table class="dataTable bordered" data-searching="true" style="overflow:auto; width:100%; background-color:#fff;">
        <thead>
        <tr>
            <th class="ribbed-cyan fg-white padding10 text-shadow">No</th>
            <th class="ribbed-cyan fg-white padding10 text-shadow">Nama Produk</th>
            <th class="ribbed-cyan fg-white padding10 text-shadow">Barcode</th>
            <th class="ribbed-cyan fg-white padding10 text-shadow">Kode Opname</th>
            <th class="ribbed-cyan fg-white padding10 text-shadow">Tanggal</th>
            <th class="ribbed-cyan fg-white padding10 text-shadow">Stok Sistem</th>
            <th class="ribbed-cyan fg-white padding10 text-shadow">Stok Fisik</th>
        </tr>
        </thead>
        <?php $i = 1; ?>
        <tbody>
        @foreach ($detail as $value)
            <tr>
                <td>{!! $i++ !!}</td>
                <td>{!! $value->barang->nama !!}</td>
                <td>{!! $value->barang->barcode !!}</td>
                <td>{!! $value->headerid->nopembelian !!}</td>
                <td>{!! $value->headerid->tanggal !!}</td>
                <td align="center">{!! $value->stok_sistem !!}</td>
                <td align="center">{!! $value->stok_fisik !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
