<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row"> 
        <div class="col-lg">
            <?php if(validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors(); ?>
            </div>
            <?php endif; ?>

            <?= $this->session->flashdata('message'); ?>

            <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#newSubMenuModal">Add New Submenu</a>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Menu</th>
                        <th>URL</th>
                        <th>Icon</th>
                        <th>Active</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach($subMenu as $sm): ?>
                    <tr>
                        <th scope="row"><?= $i++; ?></th>
                        <td><?= $sm['title']; ?></td>
                        <td><?= $sm['menu']; ?></td>
                        <td><?= $sm['url']; ?></td>
                        <td><?= $sm['icon']; ?></td>
                        <td><?= $sm['is_active'] ? 'Yes' : 'No'; ?></td>
                        <td>
                            <!-- Tombol Edit -->
                            <a href="#" class="badge text-bg-info" 
                               data-bs-toggle="modal" 
                               data-bs-target="#editSubMenuModal<?= $sm['id']; ?>">Edit</a>

                            <!-- Tombol Delete -->
                            <a href="<?= base_url('menu/deletesubmenu/' . $sm['id']); ?>" 
                               class="badge text-bg-danger"
                               onclick="return confirm('Apakah anda yakin ingin menghapus submenu ini?');">Delete</a>
                        </td>
                    </tr>

                    <!-- Modal Edit Submenu -->
                    <div class="modal fade" id="editSubMenuModal<?= $sm['id']; ?>" tabindex="-1" aria-labelledby="editSubMenuModalLabel<?= $sm['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="editSubMenuModalLabel<?= $sm['id']; ?>">Edit Submenu</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="<?= base_url('menu/editsubmenu/' . $sm['id']); ?>" method="post">
                                <div class="modal-body">
                                    <div class="form-group mb-2">
                                        <input type="text" class="form-control" name="title" value="<?= $sm['title']; ?>" required>
                                    </div>
                                    <div class="form-group mb-2">
                                        <select name="menu_id" class="form-control" required>
                                            <option value="">Select Menu</option>
                                            <?php foreach($menu as $m): ?>
                                            <option value="<?= $m['id']; ?>" <?= $sm['menu_id'] == $m['id'] ? 'selected' : ''; ?>>
                                                <?= $m['menu']; ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-2">
                                        <input type="text" class="form-control" name="url" value="<?= $sm['url']; ?>" required>
                                    </div>
                                    <div class="form-group mb-2">
                                        <input type="text" class="form-control" name="icon" value="<?= $sm['icon']; ?>" required>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active<?= $sm['id']; ?>" <?= $sm['is_active'] ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="is_active<?= $sm['id']; ?>">
                                            Active?
                                        </label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>

</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->


<!-- Modal Add New Submenu -->
<div class="modal fade" id="newSubMenuModal" tabindex="-1" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="newSubMenuModalLabel">Add New Sub Menu</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="<?= base_url('menu/submenu'); ?>" method="post">
            <div class="modal-body">
                <div class="form-group mb-2">
                    <input type="text" class="form-control" id="title" name="title" placeholder="Submenu title">
                </div>
                <div class="form-group mb-2">
                    <select name="menu_id" id="menu_id" class="form-control">
                        <option value="">Select Menu</option>
                        <?php foreach($menu as $m) : ?>
                        <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <input type="text" class="form-control" id="url" name="url" placeholder="Submenu url">
                </div>
                <div class="form-group mb-2">
                    <input type="text" class="form-control" id="icon" name="icon" placeholder="Submenu icon">
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" value="1" name="is_active" id="is_active" checked>
                    <label class="form-check-label" for="is_active">
                        Active?
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
        </div>
    </div>
</div>
