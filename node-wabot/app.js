const qrcode = require('qrcode-terminal');
const { Client, LocalAuth } = require('whatsapp-web.js');
const express = require('express');
const cors = require('cors');
const cron = require('node-cron');
const { kirimPengingat } = require('./schedule');

const app = express();
app.use(cors());

// Init WhatsApp client
const client = new Client({
    authStrategy: new LocalAuth()
});

client.on('qr', qr => {
    qrcode.generate(qr, { small: true });
    console.log('QR tersedia, silakan scan.');
});

client.on('ready', () => {
    console.log('WhatsApp siap digunakan!');
});

// Endpoint manual
app.post('/kirim-pengingat', async (req, res) => {
    await kirimPengingat(client);
    res.json({ status: 'ok', message: 'Pengingat berhasil dikirim!' });
});

// Cron otomatis jam 06:00 WIB
cron.schedule('0 6 * * *', () => {
    console.log('Cron job: mengirim pengingat otomatis...');
    kirimPengingat(client);
}, {
    timezone: "Asia/Jakarta"
});

// Jalankan WA & server
client.initialize();

app.listen(3000, () => {
    console.log('Server berjalan di http://localhost:3000');
});



