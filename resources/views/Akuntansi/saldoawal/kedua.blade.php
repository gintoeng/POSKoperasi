<table class="table table-striped table-bordered scroll responsive no-m" style="height:410px; display: -moz-groupbox;">
    <thead>
        <tr class="bg-color" style="width: 100%; display: inline-table;table-layout: fixed;">
            <th class="text-center" width="10%">No</th>
            <th class="">Kode Perkiraan</th>
            <th class="">Nama</th>
            <th class="">Jumlah</th>
        </tr>
    </thead>
    <tbody style="overflow-y: scroll;height: 375px;position: absolute;width:95%">
        <?php $i = 1; ?>
        @foreach($perkiraan as $kewajibans)
        <tr style="width: 100%;display: inline-table;table-layout: fixed;">
            <td width="10%" class="text-center">{!! $i++ !!}.</td>
            <input type="hidden" value="{!! $kewajibans->id!!}" name="kode_akun_kewajiban[]"/>
            <td>{!! $kewajibans->kode_akun!!}</td>
            <td>{!! $kewajibans->nama_akun !!}</td>
            <td><input type="text" class="form-control" name="jumlahkewajiban[]" value="0.00"></td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    $("input[name='jumlahkewajiban[]']").maskMoney();

    $("input[name='jumlahkewajiban[]']").keyup(function (e) {
        jumlah_kewajiban($(this));
    });
</script>
