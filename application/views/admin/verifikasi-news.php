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
                                    <th>Judul</th>
                                    <th>dibuat</th>
                                    <th>Act</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($news as $news_item) :
                                    if ($news_item['is_active'] == 0) : ?>

                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <a href="<?= site_url('admin/verifikasi_detail/' . $news_item['slug']); ?>"><?= $news_item['title'] ?></a>
                                            </td>
                                            <td><?= date("d F Y", strtotime($news_item['created'])); ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/prove/'); ?><?= $news_item['id']; ?>" class="badge badge-primary">Prove</a>
                                                <a href="<?= base_url('admin/hapus_verify/'); ?><?= $news_item['id']; ?>" class="badge badge-danger">Hapus</a>
                                            </td>
                                        </tr>
                                <?php
                                    endif;
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