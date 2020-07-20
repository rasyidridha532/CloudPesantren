<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pesantren | Registration Page</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="register-page" style="min-height: 586.391px;">
    <div class="register-box">
        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Register a new membership</p>
                <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                <?= form_open_multipart('auth/proses_register') ?>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Nama Lengkap" name="namalengkap" value="<?= set_value('namalengkap'); ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <?php echo form_error('namalengkap', '<small class="text-danger mt-6">', '</small>'); ?>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Email" name="email" value="<?= set_value('email'); ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <?php echo form_error('email', '<small class="text-danger mt-6">', '</small>'); ?>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" name="password1">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <?php echo form_error('password1', '<small class="text-danger mt-6">', '</small>'); ?>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Masukkan Kembali Password" name="password2">
                </div>
                <?php echo form_error('password2', '<small class="text-danger mt-6">', '</small>'); ?>
                <div class="input-group mb-3">
                    <select class="form-control" name="role" id="role" required>
                        <option value="">--Pilih Role--</option>
                        <option value="admin">Administrator</option>
                        <option value="pengurus">Pengelola</option>
                    </select>
                </div>
                <?php echo form_error('role', '<small class="text-danger mt-6">', '</small>'); ?>
                <div class="input-group mb-3">
                    <label for="myfile">Upload Foto Profil</label>
                </div>
                <div class="row">
                    <div class="col-8">
                        <input type="file" name="gambar" class="form-control">
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                    <!-- /.col -->
                </div>
                <?= form_close() ?>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
</body>

</html>