const cron = require('node-cron');
const { getMembers, getSchedules } = require('./data');

async function kirimPengingat(client) {
    try {
        const members = await getMembers();
        const schedules = await getSchedules();

        const hariIni = new Date().toLocaleDateString('id-ID', { weekday: 'long' });

        for (const member of members) {

            console.log("======================================");
            console.log("Nama:", member.name);
            console.log("WA Number (raw):", member.waNumber);
            console.log("WA Number (final):", `${member.waNumber}@c.us`);

            const jadwalMember =
                schedules[member.class]?.[hariIni] ||
                ['Belum ada jadwal hari ini'];

            const pesan = `
Halo👋🏻, Selamat Pagi ${member.name} (Kelas ${member.class})
Ini jadwalmu hari ini (${hariIni}):
${jadwalMember
  .map(j => `Jam ${j.jam_ke} (${j.waktu}) – ${j.mapel}`)
  .join('\n')}


Semangat yaa🤩‼️
            `;

            try {
                await client.sendMessage(`${member.waNumber}@c.us`, pesan);
                console.log(`✔ Pesan terkirim ke ${member.name} (${member.waNumber})`);
            } catch (err) {
                console.log(`❌ Gagal mengirim ke ${member.name} (${member.waNumber})`);
                console.log("Alasan error:", err.message);
            }
        }

    } catch (err) {
        console.error("ERROR kirimPengingat:", err);
    }
}

module.exports = { kirimPengingat };


// const cron = require('node-cron');
// const { getMembers, getSchedules } = require('./data');

// async function kirimPengingat(client) {
//     try {
//         const members = await getMembers();
//         const schedules = await getSchedules();

//         const hariIniRaw = new Date().toLocaleDateString('id-ID', { weekday: 'long' });
//         const hariIni = hariIniRaw.charAt(0).toUpperCase() + hariIniRaw.slice(1);

//         for (const member of members) {

//             console.log("======================================");
//             console.log("Nama:", member.name);
//             console.log("Class:", member.class);
//             console.log("Hari:", hariIni);
//             console.log("Schedule class:", schedules[member.class]);

//             const jadwalMember =
//                 schedules[member.class]?.[hariIni] ??
//                 ['Belum ada jadwal hari ini'];

//             const pesan = `
// Halo👋🏻, Selamat Pagi ${member.name} (Kelas ${member.class})
// Ini jadwalmu hari ini (${hariIni}):
// ${jadwalMember.map((j, i) => `${i + 1}. ${j}`).join('\n')}

// Semangat yaa🤩‼️
//             `;

//             await client.sendMessage(`${member.waNumber}@c.us`, pesan);
//             console.log(`✔ Pesan terkirim ke ${member.name}`);
//         }

//     } catch (err) {
//         console.error("ERROR kirimPengingat:", err);
//     }
// }

// module.exports = { kirimPengingat };



