-- Tugas 1: database penjualan, relasi, dan data
CREATE DATABASE IF NOT EXISTS penjualan CHARACTER SET utf8mb4;
USE penjualan;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS pembayaran, transaksi_detail, transaksi, barang, supplier, pelanggan, user;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE supplier (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100),
  telp VARCHAR(12),
  alamat TEXT
);

CREATE TABLE pelanggan (
  id VARCHAR(20) PRIMARY KEY,
  nama VARCHAR(100),
  jenis_kelamin ENUM('L','P'),
  telp VARCHAR(12),
  alamat TEXT
);

CREATE TABLE user (
  id_user TINYINT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(30),
  password VARCHAR(35),
  nama VARCHAR(50),
  alamat VARCHAR(150),
  hp VARCHAR(20),
  level TINYINT(1)
);

CREATE TABLE barang (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kode_barang VARCHAR(10),
  nama_barang VARCHAR(100),
  harga INT,
  stok INT,
  supplier_id INT,
  FOREIGN KEY (supplier_id) REFERENCES supplier(id)
);

CREATE TABLE transaksi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  waktu_transaksi DATE,
  keterangan TEXT,
  total INT DEFAULT 0,
  pelanggan_id VARCHAR(20),
  FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id)
);

CREATE TABLE transaksi_detail (
  transaksi_id INT,
  barang_id INT,
  harga INT,
  qty INT,
  PRIMARY KEY (transaksi_id, barang_id),
  FOREIGN KEY (transaksi_id) REFERENCES transaksi(id),
  FOREIGN KEY (barang_id) REFERENCES barang(id)
);

CREATE TABLE pembayaran (
  id INT AUTO_INCREMENT PRIMARY KEY,
  waktu_bayar DATETIME,
  total INT,
  metode ENUM('TUNAI','TRANSFER','EDC'),
  transaksi_id INT,
  FOREIGN KEY (transaksi_id) REFERENCES transaksi(id)
);

INSERT INTO supplier (nama, telp, alamat) VALUES
('PT Maju Jaya','081111111','Surabaya'),
('CV Sumber Rejeki','082222222','Malang'),
('UD Berkah','083333333','Sidoarjo'),
('PT Sentosa Abadi','084444444','Bangkalan'),
('CV Makmur','085555555','Madiun');

INSERT INTO pelanggan VALUES
('P001','Andi','L','086111111','Bangkalan'),
('P002','Siti','P','086222222','Surabaya'),
('P003','Budi','L','086333333','Sampang'),
('P004','Rina','P','086444444','Pamekasan'),
('P005','Dewi','P','086555555','Sumenep');

INSERT INTO user (username,password,nama,alamat,hp,level) VALUES
('admin',MD5('admin123'),'Administrator','Bangkalan','0811',1),
('kasir1',MD5('kasir123'),'Kasir Satu','Bangkalan','0812',2),
('kasir2',MD5('kasir123'),'Kasir Dua','Surabaya','0813',2),
('gudang',MD5('gudang123'),'Staf Gudang','Malang','0814',2),
('owner',MD5('owner123'),'Pemilik','Sidoarjo','0815',1);

INSERT INTO barang (kode_barang,nama_barang,harga,stok,supplier_id) VALUES
('BRG001','Beras 5kg',65000,50,1),
('BRG002','Minyak Goreng 2L',38000,40,2),
('BRG003','Gula 1kg',16000,60,3),
('BRG004','Telur 1kg',28000,30,4),
('BRG005','Kopi Sachet',2500,200,5),
('BRG006','Teh Kotak',5000,100,1);

INSERT INTO transaksi (waktu_transaksi,keterangan,total,pelanggan_id) VALUES
('2026-11-01','Belanja bulanan',0,'P001'),
('2026-11-01','Belanja harian',0,'P002'),
('2026-11-02','Pembelian grosir',0,'P003'),
('2026-11-02','Belanja harian',0,'P004'),
('2026-11-03','Pembelian rutin',0,'P005'),
('2026-11-03','Belanja harian',0,'P001'),
('2026-11-04','Belanja bulanan',0,'P002'),
('2026-11-04','Pembelian grosir',0,'P003'),
('2026-11-05','Belanja harian',0,'P004'),
('2026-11-05','Pembelian rutin',0,'P005');

-- Teh Kotak (id 6) sengaja tidak dipakai di detail, untuk uji hapus (soal 3)
INSERT INTO transaksi_detail (transaksi_id,barang_id,harga,qty) VALUES
(1,1,65000,2),(1,2,38000,1),
(2,3,16000,3),(3,1,65000,5),
(3,4,28000,2),(4,5,2500,10),
(5,2,38000,2),(6,3,16000,1),
(7,4,28000,1),(8,1,65000,3),
(9,5,2500,20),(10,2,38000,1);

UPDATE transaksi t SET total = (
  SELECT COALESCE(SUM(harga*qty),0) FROM transaksi_detail d WHERE d.transaksi_id = t.id
);

INSERT INTO pembayaran (waktu_bayar,total,metode,transaksi_id)
SELECT NOW(), total, 'TUNAI', id FROM transaksi;
