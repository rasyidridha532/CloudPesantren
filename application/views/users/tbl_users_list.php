<div class="content-wrapper">
    <div class="content-header">
        <div class="content-fluid">
            <h2 style="margin-top:0px">User Pesantren</h2>
            <div style="margin-bottom: 10px">
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
                    <form action="<?php echo site_url('users'); ?>" class="form-inline" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                            <span class="input-group-btn">
                                <?php
                                if ($q <> '') {
                                ?>
                                    <a href="<?php echo site_url('users'); ?>" class="btn btn-default">Reset</a>
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
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Gambar</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php
                    foreach ($users_data as $users) {
                    ?>
                        <tr>
                            <td width="80px"><?php echo ++$start ?></td>
                            <td><?php echo $users->nama ?></td>
                            <td><?php echo $users->email ?></td>
                            <td><?php echo $users->password ?></td>
                            <td><?php echo $users->gambar ?></td>
                            <td><?php echo $users->role ?></td>
                            <td>
                                <a href="<?= site_url('users/update/' . $users->id); ?>" class="btn btn-block btn-warning btn-sm">Update</a>
                                <a href="<?= site_url('users/delete/' . $users->id); ?>" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus ?')" class="btn btn-block btn-danger btn-sm">Delete</a>
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
            <a href="#" class="btn btn-primary">Jumlah User : <?php echo $total_rows ?></a>
        </div>
        <div class="col-md-6 text-right">
            <?php echo $pagination ?>
        </div>
    </div>
</div>
</body>