<table border="1">
	<tr>
		<th>No.</th>
		<th>Nama Barang</th>
		<th>Klasifikasi</th>
		<th>Unit</th>
    <th>Curr</th>
    <th>harga_jual</th>
    <th>harga_beli</th>
    <th>Diskon</th>
    <th>Stock</th>
    <th>Barcode</th>
	</tr>
	<?php
	//koneksi ke database
	mysql_connect("localhost", "root", "firman18;//");
	mysql_select_db("koperasi");

	//query menampilkan data
	$sql = mysql_query("SELECT * FROM produk ORDER BY id ASC");
	$no = 1;
	while($data = mysql_fetch_assoc($sql)){
		echo '
		<tr>
			<td>'.$no.'</td>
			<td>'.$data['nama'].'</td>
			<td>'.$data['kelas'].'</td>
			<td>'.$data['jurusan'].'</td>
		</tr>
		';
		$no++;
	}
	?>
</table>
