<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row"> 
        <div class="col-lg-6">

            <?= form_error('role', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>

            <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#newRoleModal">Add New Role</a>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach($role as $r) : ?>
                    <tr>
                        <th scope="row"><?= $i++; ?></th>
                        <td><?= $r['role']; ?></td>
                        <td>
                            <a href="<?= base_url('admin/roleaccess/') . $r['id']; ?>" class="badge text-bg-secondary">Access</a>
                            
                            <!-- Edit Button -->
                            <a href="#" class="badge text-bg-info" data-bs-toggle="modal" data-bs-target="#editRoleModal<?= $r['id']; ?>">Edit</a>

                            <!-- Delete Button -->
                            <a href="<?= base_url('admin/deleterole/' . $r['id']); ?>" class="badge text-bg-danger" onclick="return confirm('Are you sure you want to delete this role?');">Delete</a>
                        </td>
                    </tr>

                    <!-- Edit Role Modal -->
                    <div class="modal fade" id="editRoleModal<?= $r['id']; ?>" tabindex="-1" aria-labelledby="editRoleModalLabel<?= $r['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="editRoleModalLabel<?= $r['id']; ?>">Edit Role</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="<?= base_url('admin/editrole/' . $r['id']); ?>" method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="role" name="role" value="<?= $r['role']; ?>" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Edit Modal -->

                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>      

</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->   

<!-- Add Role Modal -->
<div class="modal fade" id="newRoleModal" tabindex="-1" aria-labelledby="newRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="newRoleModalLabel">Add New Role</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="<?= base_url('admin/role'); ?>" method="post">
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control" id="role" name="role" placeholder="Role name" required>
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
