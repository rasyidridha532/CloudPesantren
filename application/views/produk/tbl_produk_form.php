<div class="content-wrapper">
    <div class="content-header">
        <div class="content-fluid">
            <h2 style="margin-top:0px col-8"><?= $title; ?></h2>
            <div style="margin-bottom: 10px">
                <div class="col-md-4 text-center">
                    <div style="margin-top: 8px" id="message alert alert-success">
                        <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <?= form_open_multipart($action) ?>
        <div class="form-group">
            <label for="varchar">Nama Produk <?php echo form_error('nama_produk') ?></label>
            <input type="text" class="form-control" name="nama_produk" id="nama_produk" placeholder="Nama Produk" value="<?php echo $nama_produk; ?>" />
        </div>
        <div class="form-group">
            <label for="varchar">Jenis <?php echo form_error('jenis') ?></label>
            <select class="form-control" name="id_jenis" id="id_jenis" required>
                <option value="">--Pilih Jenis--</option>
                <?php foreach ($jenis as $get) { ?>
                    <option value="<?= $get->id_jenis; ?>" <?= $id_jenis == $get->id_jenis ? "selected" : "" ?>><?= $get->nama_jenis; ?>
                    <?php
                } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="int">Stok <?php echo form_error('harga') ?></label>
            <input type="number" class="form-control" name="stok" id="stok" placeholder="Jumlah Stok" value="<?php echo $stok; ?>" />
        </div>
        <div class="form-group">
            <label for="int">Harga <?php echo form_error('harga') ?></label>
            <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga" value="<?php echo $harga; ?>" />
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="Gambar">Pilih Gambar...</label>
            <input type="file" name="gambar" class="form-control">
        </div>
        <input type="hidden" name="id_produk" value="<?php echo $id_produk; ?>" />
        <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
        <a href="<?php echo site_url('produk') ?>" class="btn btn-default">Cancel</a>
        <?= form_close() ?>
    </div>
</div>
</body>