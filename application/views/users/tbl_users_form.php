<div class="content-wrapper">
    <div class="content-header">
        <div class="content-fluid">
            <h2 style="margin-top:0px col-8">Edit User</h2>
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
        <form action="<?php echo $action; ?>" method="post">
            <div class="form-group">
                <label for="varchar">Nama Lengkap<?php echo form_error('nama') ?></label>
                <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?php echo $nama; ?>" />
            </div>
            <div class="form-group">
                <label for="alamat">Email<?php echo form_error('email') ?></label>
                <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" />
            </div>
            <div class="form-group">
                <label for="alamat">Password<?php echo form_error('password1', '<small class="text-danger mt-6">', '</small>'); ?></label>
                <input type="password" class="form-control" placeholder="Password" name="password1">
            </div>
            <div class="form-group">
                <label for="alamat">Masukkan Kembali Password<?php echo form_error('password2', '<small class="text-danger mt-6">', '</small>'); ?></label>
                <input type="password" class="form-control" placeholder="Password" name="password2">
            </div>
            <div class="form-group">
                <input type="file" name="gambar" class="form-control">
            </div>
            <div class="form-group">
                <label for="varchar">Role<?php echo form_error('role') ?></label>
                <select class="form-control" name="role" id="role" required>
                    <option value="">--Pilih Role--</option>
                    <option value="admin">Administrator</option>
                    <option value="member">Pengelola</option>
                </select>
            </div>
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
            <a href="<?php echo site_url('users') ?>" class="btn btn-default">Cancel</a>
        </form>
    </div>
</div>
</body>