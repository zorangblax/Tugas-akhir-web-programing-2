<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col">
            <a class="btn btn-primary mb-4" href="<?= base_url('user/pengajuan_berita') ?>" role="button">Pengajuan Berita</a>
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
                                    <th>email</th>
                                    <th>Act</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($news as $news_item) :
                                    if ($news_item['is_active'] == 0) :
                                        $isCurrentUser = ($news_item['email'] === $user['email']); ?>

                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <a href="<?= site_url('user/pengajuan_detail/' . $news_item['slug']); ?>"><?= $news_item['title'] ?></a>
                                            </td>
                                            <td><?= $news_item['email'] ?></td>
                                            <td> <?php if ($isCurrentUser) : ?>
                                                    <a href="<?= base_url('user/edit_data/') . $news_item['id']; ?>" class="badge badge-primary">Edit</a>
                                                    <a href="<?= base_url('user/hapus_data/') . $news_item['id']; ?>" class="badge badge-danger">Hapus</a>
                                                <?php else : ?>
                                                    <button class="badge badge-secondary" disabled>Readonly</button>
                                                <?php endif; ?>
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