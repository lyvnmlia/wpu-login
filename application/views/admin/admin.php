<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Tombol untuk Mengirim Pengingat Pesan</h1>

    <!-- Notifikasi sukses -->
    <?php if ($this->session->flashdata('msg_success')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('msg_success'); ?>
        </div>
    <?php endif; ?>

    <!-- Notifikasi error -->
    <?php if ($this->session->flashdata('msg_error')): ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata('msg_error'); ?>
        </div>
    <?php endif; ?>


    <!-- Tombol Kirim -->
    <button id="btnKirim" class="btn btn-primary">
        Kirim Pesan Pengingat
    </button>

    <!-- Status -->
    <div id="status" class="mt-3 font-weight-bold"></div>
</div>
</div>


<!-- Script Kirim ke Node.js -->
<script>
document.getElementById('btnKirim').addEventListener('click', async () => {

    const statusEl = document.getElementById('status');
    statusEl.innerText = "Mengirim...";

    try {
        const response = await fetch('http://localhost:3000/kirim-pengingat', {
            method: 'POST'
        });

        const result = await response.json();
        statusEl.innerText = result.message;

    } catch (error) {
        statusEl.innerText = "Gagal mengirim!";
    }
});
</script>


