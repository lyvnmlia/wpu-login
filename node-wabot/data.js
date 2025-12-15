const mysql = require('mysql2/promise');

const pool = mysql.createPool({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'wpu-login',
  port: 3307,
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0
});

async function getMembers() {
  const [rows] = await pool.query(`
      SELECT 
          s.id, 
          s.nama_siswa, 
          k.nama as nama_kelas,
          j.nama as nama_jurusan,
          s.nomor_whatsapp
      FROM m_siswa s
      JOIN m_kelas k ON k.id = s.id_kelas
      JOIN m_jurusan j ON j.id = k.id_jurusan
  `);

  return rows.map(row => ({
    id: row.id,
    name: row.nama_siswa,
    class: `${row.nama_kelas} ${row.nama_jurusan}`,
    waNumber: row.nomor_whatsapp
}));

}


async function getSchedules() {
  const [rows] = await pool.query(`
      SELECT 
          k.nama as nama_kelas,
          j.nama as nama_jurusan,
          jp.hari,
          jp.id_jam,
          jam.jam_ke,
          jam.waktu_mulai,
          jam.waktu_selesai,
          mp.name_mapel 
      FROM jadwal_pelajaran jp
      JOIN jam_pelajaran jam ON jam.id_jam = jp.id_jam
      JOIN m_mapel mp ON mp.id = jp.id_mapel
      JOIN m_kelas k ON k.id = jp.id_kelas
      JOIN m_jurusan j ON j.id = k.id_jurusan
      ORDER BY jam.jam_ke ASC
  `);

  const schedules = {};

  rows.forEach(row => {
    const kelas = `${row.nama_kelas} ${row.nama_jurusan}`;
    const hari  = row.hari;

    if (!schedules[kelas]) schedules[kelas] = {};
    if (!schedules[kelas][hari]) schedules[kelas][hari] = [];

    schedules[kelas][hari].push({
      jam_ke: row.jam_ke,
      waktu: `${row.waktu_mulai}–${row.waktu_selesai}`,
      mapel: row.name_mapel
    });
  });

  return schedules;
}



module.exports = { getMembers, getSchedules };

// TEST CONNECTION
pool.getConnection()
  .then(() => console.log('✔ MySQL terkoneksi'))
  .catch(err => console.error('❌ MySQL ERROR:', err));



