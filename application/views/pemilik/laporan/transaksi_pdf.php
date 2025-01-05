<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
			.font-arial {
				font-family: Arial;
			}
			table {
				width: 100%;
				border-collapse: collapse;
				font-size: 12px;
				font-family: 'Courier New', Courier, monospace;
			}
			th {
				background-color: #f4f4f4;
			}
    </style>
</head>
<body>
	<h3 style="text-align: center;">Laporan Transaksi</h3>
	<table style="border: none !important; width: 50% !important;">
		<tr>
			<td>Toko</td>
			<td>: <?= 'KING VAPEZONE' ?></td>
		</tr>
		<tr>
			<td>Tanggal Cetak</td>
			<td>: <?= date('d-m-Y') ?></td>
		</tr>
		<tr>
			<td>Periode</td>
			<td>: <?= format_periode($start_date, $end_date) ?></td>
		</tr>
	</table>
	<br>
	<table style="border: 1px solid #ededed;">
			<thead>
				<tr style="border: 1px solid #ededed;" class="font-arial">
					<th style="padding: 8px;">No. Transaksi</th>
					<th>Pelanggan</th>
					<th style="text-align: center !important;">Waktu Transaksi</th>
					<th style="text-align: center !important;">Ekspedisi</th>
					<th style="text-align: center !important;">Status</th>
					<th style="text-align: right !important;">Ongkir (Rp)</th>
					<th style="text-align: right !important;">Subtotal (Rp)</th>
					<th style="text-align: right !important; padding: 8px;">Total (Rp)</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$total_ongkir = [];
					$sub_total = [];
					$total = [];
					foreach ($transactions as $row):
				?>
					<tr>
						<td style="padding: 8px;"><?= $row->order_id ?></td>
						<td><?= $row->name ?></td>
						<td style="text-align: center;"><?= date('d-m-Y H:i', strtotime($row->transaction_time)) ?></td>
						<td style="text-align: center;"><?= Ucwords($row->ekspedisi) ?></td>
						<td style="text-align: center !important;"><?= $row->status == '0' ? 'Pending' : 'Selesai' ?></td>
						<td style="text-align: right;"><?= number_format($row->total_ongkir, 0, ',', '.') ?></td>
						<td style="text-align: right;"><?= number_format($row->subtotal, 0, ',', '.') ?></td>
						<td style="text-align: right; padding: 8px;"><?= number_format($row->total_bayar, 0, ',', '.') ?></td>
					</tr>
				<?php
						$total_ongkir[] = $row->total_ongkir;
						$subtotal[] = $row->subtotal;
						$total[] = $row->total_bayar;
					endforeach;
				?>
			</tbody>
	</table>
	<table border="0" style="margin-top: 10px; font-size: 14px; font-weight: bold;">
		<tr>
			<td style="text-align: right;" colspan="7">Total Ongkir</td>
			<td width="20%" style="text-align: right;">Rp. <?= number_format(array_sum($total_ongkir), 0, ',', '.') ?></td>
		</tr>
		<tr>
			<td style="text-align: right;" colspan="7">Subtotal</td>
			<td width="20%" style="text-align: right;">Rp. <?= number_format(array_sum($subtotal), 0, ',', '.') ?></td>
		</tr>
		<tr>
			<td style="text-align: right;" colspan="7">Total</td>
			<td width="20%" style="text-align: right;">Rp. <?= number_format(array_sum($total), 0, ',', '.') ?></td>
		</tr>
	</table>
</body>
</html>
