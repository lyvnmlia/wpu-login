<div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" method="post" action="<?= base_url('auth/registration'); ?>">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Full name" value="<?= set_value('name');?>">
                                    <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Email Address" value="<?= set_value('email');?>">
                                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Password">
                                        <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Repeat Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <select name="id_kelas" class="form-control">
                                        <option value="">-- Pilih Kelas --</option>
                                        <?php foreach ($kelas as $k): ?>
                                            <option value="<?= $k['id']; ?>" <?= set_select('id', $k['id']); ?>>
                                                <?= $k['nama']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= form_error('id_kelas', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <select name="id_jurusan" class="form-control">
                                        <option value="">-- Pilih Jurusan --</option>
                                        <?php foreach ($jurusan as $j): ?>
                                            <option value="<?= $j['id']; ?>" <?= set_select('id', $j['id']); ?>>
                                                <?= $j['nama']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= form_error('id_jurusan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="whatsapp">Nomor WhatsApp</label>
                                    <input type="text" class="form-control" id="whatsapp" name="whatsapp" placeholder="Contoh: 6281234567890" required>
                                </div>

                                <script>
                                document.getElementById('whatsapp').addEventListener('input', function(){
                                    let wa = this.value.replace(/\D/g, '');

                                    // auto convert: 08xxxx → 628xxxx
                                    if (wa.startsWith("08")) {
                                        wa = "62" + wa.substring(1);
                                    }

                                    // pastikan hanya angka
                                    this.value = wa;
                                });
                                </script>


                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="<?= base_url('auth/forgotpassword'); ?>">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="<?= base_url('auth'); ?>">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>    