<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col">
            <div>
                <?= $this->session->flashdata('message'); ?>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">List Berita</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>nomor</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Dibuat Pada</th>
                                    <th>Act</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($datauser as $dts) :
                                ?>

                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $dts['name'] ?></td>
                                        <td><?= $dts['email'] ?></td>
                                        <td><?php if ($dts['role_id'] == 1) {
                                                echo 'Admin';
                                            } else {
                                                echo 'User';
                                            }; ?></td>
                                        <td>
                                            <?= date('d F Y', $dts['date_created']) ?>
                                        </td>
                                        <td><?php if ($user['email'] === $dts['email']) : ?>
                                                <span class="badge badge-danger">SAAT INI ANDA BERADA DI AKUN INI!!!</span>
                                            <?php else : ?>
                                                <a href="<?= base_url('admin/ubahrole/'); ?><?= $dts['id']; ?>" class="badge badge-primary">Ubah Role</a>
                                                <a href="<?= base_url('admin/hapus_user/'); ?><?= $dts['id']; ?>" class="badge badge-danger">Hapus</a>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                <?php
                                endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->


</div>
<!-- End of Main Content -->