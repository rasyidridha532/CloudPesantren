<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Tbl_file <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Judul <?php echo form_error('judul') ?></label>
            <input type="text" class="form-control" name="judul" id="judul" placeholder="Judul" value="<?php echo $judul; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Nama File <?php echo form_error('nama_file') ?></label>
            <input type="text" class="form-control" name="nama_file" id="nama_file" placeholder="Nama File" value="<?php echo $nama_file; ?>" />
        </div>
	    <div class="form-group">
            <label for="float">Size <?php echo form_error('size') ?></label>
            <input type="text" class="form-control" name="size" id="size" placeholder="Size" value="<?php echo $size; ?>" />
        </div>
	    <div class="form-group">
            <label for="timestamp">Uploaded At <?php echo form_error('uploaded_at') ?></label>
            <input type="text" class="form-control" name="uploaded_at" id="uploaded_at" placeholder="Uploaded At" value="<?php echo $uploaded_at; ?>" />
        </div>
	    <input type="hidden" name="id_file" value="<?php echo $id_file; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('file') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>