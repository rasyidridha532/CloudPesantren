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
        <h2 style="margin-top:0px">Tbl_file Read</h2>
        <table class="table">
	    <tr><td>Judul</td><td><?php echo $judul; ?></td></tr>
	    <tr><td>Nama File</td><td><?php echo $nama_file; ?></td></tr>
	    <tr><td>Size</td><td><?php echo $size; ?></td></tr>
	    <tr><td>Uploaded At</td><td><?php echo $uploaded_at; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('file') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>