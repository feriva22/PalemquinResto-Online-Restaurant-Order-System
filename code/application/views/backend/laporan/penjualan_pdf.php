<h3>
    Laporan Penjualan
</h3>
<h4>Tipe : <?php echo $type_report;?></h4>
<h4>Tanggal Mulai : <?php echo $start_date;?></h4>
<h4>Tanggal Berakhir : <?php echo $end_date;?></h4>
<table cellspacing="1" bgcolor="#666666" cellpadding="2">
                                <thead>
                                    <tr bgcolor="#ffffff">
                                        <th width="20%" align="center">Waktu</th>
                                        <th width="20%" align="center">Total Penjualan</th>
                                        <th width="20%" align="center">Total Pajak</th>
                                        <th width="20%" align="center">Total Diskon</th>
                                        <th width="20%" align="center">Total Keuntungan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $all_penjualan = 0;
                                    $all_tax = 0;
                                    $all_disc = 0;
                                    $all_net = 0;
                                    foreach($report as $row):
                                    ?>
                                    <tr bgcolor="#ffffff">
                                        <td><?php echo $row->waktu;?></td>
                                        <td align="right"><?php echo number_rp($row->tot_penjualan);?></td>
                                        <td align="right"><?php echo number_rp($row->tot_tax);?></td>
                                        <td align="right"><?php echo number_rp($row->tot_discount);?></td>
                                        <td align="right"><?php echo number_rp($row->tot_net);?></td>
                                        <?php 
                                        $all_penjualan += $row->tot_penjualan;
                                        $all_tax += $row->tot_tax;
                                        $all_disc += $row->tot_discount;
                                        $all_net += $row->tot_net;
                                        ?>
                                    </tr>
                                    <?php endforeach;?>
                                    <!-- section total-->
                                    <tr bgcolor="#ffffff">
                                        <td>Total:</td>
                                        <td align="right"><?php echo number_rp($all_penjualan);?></td>
                                        <td align="right"><?php echo number_rp($all_tax);?></td>
                                        <td align="right"><?php echo number_rp($all_disc);?></td>
                                        <td align="right"><?php echo number_rp($all_net);?></td>
                                    </tr>
                                </tbody>
                            </table>