<!-- Begin Page Content -->
<div class="container-fluid">
    <script src="<?= base_url('assets/ckeditor'); ?>/ckeditor.js"></script>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit</h1>

    <div class="row">
        <div class="col-lg-8">
            <?= form_open_multipart('admin/save_prove'); ?>
            <div class="form-group row">
                <label for="title" class="col-sm-2 col-form-label">Title</label>
                <input type="hidden" name="id" value="<?= $news['id'];  ?>">

                <div class="col-sm-10">
                    <input type="text" class="form-control" id="title" name="title" value="<?= $news['title'];  ?>" autocomplete="off">
                    <?= form_error('title', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="title" class="col-sm-2 col-form-label">Kategori</label>
                <div class="col-sm-5">
                    <select class="custom-select" name="category" id="category">
                        <option value="1"> Politik</option>
                        <option value="2"> Olahraga</option>
                        <option value="3"> Lainnya</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="title" class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-5">
                    <select class="custom-select" name="status" id="status" readonly>
                        <option value="1"> Disetujui</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2">Picure</div>
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="<?= base_url('assets/img/news/') . $news['image']; ?>" class="img-thumbnail">
                        </div>
                        <div class="col-sm-9">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <label class="custom-file-label" for="image"><?= $news['image'] ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="body" class="col-sm-2 col-form-label">body</label>
                <div class="col-sm-10">
                    <textarea id="body" name="body"><?= $news['body']; ?></textarea>
                    <?= form_error('body', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
            <div class="form-group row justify-content-end">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">
                        Masukan Ke Berita
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- /.container-fluid -->


</div>

<!-- End of Main Content -->