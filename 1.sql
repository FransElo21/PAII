-- Menunggu
INSERT INTO undangan_pengunjung (SUBJECT, keterangan, STATUS, waktu_temu, waktu_kembali, lokasi_id, host_id, pengunjung_id, created_at, updated_at) VALUES
('Undangan Menunggu 1', 'Keterangan untuk undangan Menunggu 1', 'Menunggu', NOW() + INTERVAL 2 DAY, NOW() + INTERVAL 3 DAY, 6, 9, 1, NOW(), NOW()),
('Undangan Menunggu 2', 'Keterangan untuk undangan Menunggu 2', 'Menunggu', NOW() + INTERVAL 2 DAY, NOW() + INTERVAL 3 DAY, 6, 9, 1, NOW(), NOW()),
('Undangan Menunggu 3', 'Keterangan untuk undangan Menunggu 3', 'Menunggu', NOW() + INTERVAL 2 DAY, NOW() + INTERVAL 3 DAY, 6, 9, 1, NOW(), NOW());

-- Sedang Berjalan
INSERT INTO undangan_pengunjung (SUBJECT, keterangan, STATUS, waktu_temu, waktu_kembali, lokasi_id, host_id, pengunjung_id, created_at, updated_at) VALUES
('Undangan Sedang Berjalan 1', 'Keterangan untuk undangan Sedang Berjalan 1', 'Sedang Berjalan', NOW() + INTERVAL 2 DAY, NOW() + INTERVAL 3 DAY, 6, 9, 1, NOW(), NOW()),
('Undangan Sedang Berjalan 2', 'Keterangan untuk undangan Sedang Berjalan 2', 'Sedang Berjalan', NOW() + INTERVAL 2 DAY, NOW() + INTERVAL 3 DAY, 6, 9, 1, NOW(), NOW()),
('Undangan Sedang Berjalan 3', 'Keterangan untuk undangan Sedang Berjalan 3', 'Sedang Berjalan', NOW() + INTERVAL 2 DAY, NOW() + INTERVAL 3 DAY, 6, 9, 1, NOW(), NOW());

-- Kadaluarsa
INSERT INTO undangan_pengunjung (SUBJECT, keterangan, STATUS, waktu_temu, waktu_kembali, lokasi_id, host_id, pengunjung_id, created_at, updated_at) VALUES
('Undangan Kadaluarsa 1', 'Keterangan untuk undangan Kadaluarsa 1', 'Kadaluarsa', NOW() + INTERVAL 2 DAY, NOW() + INTERVAL 3 DAY, 6, 9, 1, NOW(), NOW()),
('Undangan Kadaluarsa 2', 'Keterangan untuk undangan Kadaluarsa 2', 'Kadaluarsa', NOW() + INTERVAL 2 DAY, NOW() + INTERVAL 3 DAY, 6, 9, 1, NOW(), NOW()),
('Undangan Kadaluarsa 3', 'Keterangan untuk undangan Kadaluarsa 3', 'Kadaluarsa', NOW() + INTERVAL 2 DAY, NOW() + INTERVAL 3 DAY, 6, 9, 1, NOW(), NOW());

-- Ditolak
INSERT INTO undangan_pengunjung (SUBJECT, keterangan, STATUS, waktu_temu, waktu_kembali, lokasi_id, host_id, pengunjung_id, created_at, updated_at) VALUES
('Undangan Ditolak 1', 'Keterangan untuk undangan Ditolak 1', 'Ditolak', NOW() + INTERVAL 2 DAY, NOW() + INTERVAL 3 DAY, 6, 9, 1, NOW(), NOW()),
('Undangan Ditolak 2', 'Keterangan untuk undangan Ditolak 2', 'Ditolak', NOW() + INTERVAL 2 DAY, NOW() + INTERVAL 3 DAY, 6, 9, 1, NOW(), NOW()),
('Undangan Ditolak 3', 'Keterangan untuk undangan Ditolak 3', 'Ditolak', NOW() + INTERVAL 2 DAY, NOW() + INTERVAL 3 DAY, 6, 9, 1, NOW(), NOW());

