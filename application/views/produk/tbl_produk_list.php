<div class="content-wrapper">
    <div class="content-header">
        <div class="content-fluid">
            <h2 style="margin-top:0px">Produk Pesantren</h2>
            <div style="margin-bottom: 10px">
                <div class="col-12"><br><br>
                    <?php echo anchor(site_url('produk/create'), 'Tambah Produk', 'class="btn btn-primary"'); ?>
                </div>
                <div class="col-md-4 text-center">
                    <div style="margin-top: 8px" id="message alert alert-success">
                        <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <form action="<?php echo site_url('produk'); ?>" class="form-inline" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                            <span class="input-group-btn">
                                <?php
                                if ($q <> '') {
                                ?>
                                    <a href="<?php echo site_url('produk'); ?>" class="btn btn-default">Reset</a>
                                <?php
                                }
                                ?>
                                <button class="btn btn-primary" type="submit">Search</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Jenis Produk</th>
                            <th>Harga</th>
                            <th>Stok Barang</th>
                            <th>Gambar</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php
                    foreach ($produk_data as $produk) {
                    ?>
                        <tr>
                            <td width="80px"><?php echo ++$start ?></td>
                            <td><?php echo $produk->nama_produk ?></td>
                            <td><?php echo $produk->nama_jenis ?></td>
                            <td>Rp<?php echo $produk->harga ?></td>
                            <td><?php echo $produk->stok ?></td>
                            <td><img src="<?php echo base_url(); ?>uploads/file/<?php echo $produk->gambar ?>"></td>
                            <td>
                                <a href="<?= site_url('produk/update/' . $produk->id_produk); ?>" class="btn btn-block btn-warning btn-sm">Update</a>
                                <?php if ($role = 'Admin') {  ?>
                                    <a href="<?= site_url('produk/delete/' . $produk->id_produk); ?>" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus ?')" class="btn btn-block btn-danger btn-sm">Delete</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
    <div class="row col-12">
        <div class="col-md-6">
            <a href="#" class="btn btn-primary">Jumlah Produk : <?php echo $total_rows ?></a>
        </div>
        <div class="col-md-6 text-right">
            <?php echo $pagination ?>
        </div>
    </div>
</div>
</body>