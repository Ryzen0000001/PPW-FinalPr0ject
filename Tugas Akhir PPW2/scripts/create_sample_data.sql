-- Sample data for testing the website
-- Insert sample stations
INSERT INTO Stasiun (nama_stasiun, kode_stasiun, kelas_stasiun) VALUES
('Jakarta Gambir', 'GMR', 'A'),
('Bandung', 'BD', 'A'),
('Yogyakarta', 'YK', 'A'),
('Surabaya Gubeng', 'SGU', 'A'),
('Semarang Tawang', 'SMT', 'A'),
('Solo Balapan', 'SLO', 'A'),
('Cirebon', 'CN', 'A'),
('Purwokerto', 'PWT', 'A'),
('Pasar Senen', 'PSE', 'A'),
('Lempuyangan', 'LPN', 'B');

-- Insert sample trains
INSERT INTO Kereta (nama_ka, asal_stasiun_id, tujuan_stasiun_id, jam_keberangkatan) VALUES
('Parahyangan', 1, 2, '06:00:00'),
('Taksaka', 1, 3, '07:30:00'),
('Argo Bromo Anggrek', 1, 4, '20:10:00'),
('Gajayana', 1, 4, '18:00:00'),
('Bima', 1, 4, '14:35:00'),
('Jayakarta', 4, 9, '13:50:00'),
('Progo', 10, 9, '14:00:00'); 

-- Insert sample classes
INSERT INTO Kelas (kereta_no, kelas, rangkaian) VALUES
(1, 'Eksekutif', 'Baja Nirkarat'),
(1, 'Ekonomi', 'Baja Nirkarat'),
(2, 'Eksekutif', 'Baja Nirkarat'),
(3, 'Eksekutif', 'Baja Nirkarat'),
(4, 'Eksekutif', 'Baja Nirkarat'),
(5, 'Eksekutif', 'Baja Nirkarat'),
(6, 'Ekonomi', 'Baja Ringan'),
(7, 'Ekonomi', 'Baja Nirkarat');

-- Insert sample regular tariffs
INSERT INTO Tarif (kereta_no, asal_stasiun_id, tujuan_stasiun_id, tarif) VALUES
(1, 1, 2, 300000),
(2, 1, 3, 450000),
(3, 1, 4, 750000),
(4, 1, 4, 650000),
(5, 1, 4, 550000),
(6, 4, 9, 360000),
(7, 10, 9, 270000);

-- Insert sample special tariffs (for logged-in users)
INSERT INTO Tarif_Khusus (kereta_no, asal_stasiun_id, tujuan_stasiun_id, tarif_khusus) VALUES
(1, 1, 2, 235000),
(6, 4, 9, 252000),
(7, 10, 9, 189000);

-- Insert sample stops
INSERT INTO Pemberhentian (kereta_no, stasiun_id, jam_ketibaan, tujuan) VALUES
(1, 2, '09:00:00', 'Bandung'),
(2, 7, '09:00:00', 'Cirebon'),
(2, 8, '12:30:00', 'Purwokerto'),
(2, 3, '15:05:00', 'Yogyakarta'),
(6, 6, '17:34:00', 'Solo Balapan'),
(6, 10, '18:26:00', 'Lempuyangan'),
(6, 8, '21:04:00', 'Purwokerto'),
(6, 7, '23:12:00', 'Cirebon'),
(6, 9, '02:35:00', 'Pasar Senen');
