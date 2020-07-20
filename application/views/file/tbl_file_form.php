<div class="content-wrapper">
    <div class="content-header">
        <div class="content-fluid">
            <h2 style="margin-top:0px col-8">Upload File</h2>
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
        <!-- <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data"> -->
        <?= form_open_multipart($action) ?>
        <div class="form-group">
            <label for="varchar">Judul <?php echo form_error('judul') ?></label>
            <input type="text" class="form-control" name="judul" id="judul" placeholder="Judul" value="<?php echo $judul; ?>" />
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="File">Pilih File...</label>
            <input type="file" name="file" class="form-control">
        </div>
        <input type="hidden" name="id_file" value="<?php echo $id_file; ?>" />
        <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
        <a href="<?php echo site_url('file') ?>" class="btn btn-default">Cancel</a>
        <?= form_close() ?>
    </div>
</div>
</body>