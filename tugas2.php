<?php
class Buku {
    private string $kodeBuku;
    private string $judul;
    private int $stok;
 
    public function __construct(string $kodeBuku, string $judul, int $stok = 0) {
        $kodeBuku = trim($kodeBuku);
        if ($kodeBuku === "") {
            throw new InvalidArgumentException("Kode buku wajib diisi");
        }
        if ($stok < 0) {
            throw new InvalidArgumentException("Stok awal tidak boleh negatif");
        }
        $this->kodeBuku = $kodeBuku;
        $this->setJudul($judul);
        $this->stok = $stok;
    }
 
    public function getKodeBuku(): string { return $this->kodeBuku; }
    public function getJudul(): string    { return $this->judul; }
    public function getStok(): int        { return $this->stok; }
    // tidak ada setKodeBuku() dan tidak ada setStok()
 
    public function setJudul(string $judul): void {
        $judul = trim($judul);
        if ($judul === "") {
            throw new InvalidArgumentException("Judul buku wajib diisi");
        }
        $this->judul = $judul;
    }
 
    public function tambahStok(int $jumlah): void {
        if ($jumlah <= 0) {
            throw new InvalidArgumentException("Jumlah tambahan stok harus lebih dari 0");
        }
        $this->stok += $jumlah;
    }
 
    public function kurangiStok(int $jumlah): void {
        if ($jumlah <= 0) {
            throw new InvalidArgumentException("Jumlah pengurangan stok harus lebih dari 0");
        }
        if ($jumlah > $this->stok) {
            throw new InvalidArgumentException(
                "Stok tidak mencukupi. Stok saat ini: " . $this->stok);
        }
        $this->stok -= $jumlah;
    }
}
 
echo "<b>PENGUJIAN VALID</b><br>";
$b = new Buku("BK-101", "Algoritma dan Struktur Data", 8);
echo "Valid 1 -> " . $b->getKodeBuku() . " | " . $b->getJudul()
   . " | stok awal " . $b->getStok() . "<br>";
$b->tambahStok(12);
$b->kurangiStok(5);
echo "Valid 2 -> stok setelah +12 dan -5: " . $b->getStok() . "<br><br>";
 
echo "<b>PENGUJIAN TIDAK VALID</b><br>";
$uji = [
    "Tidak valid 1 (judul spasi)"      => fn() => $b->setJudul("   "),
    "Tidak valid 2 (kurangi 40)"       => fn() => $b->kurangiStok(40),
    "Tidak valid 3 (tambah -3)"        => fn() => $b->tambahStok(-3),
    "Tidak valid 4 (stok awal negatif)" => fn() => new Buku("BK-102", "Basis Data", -1),
];
foreach ($uji as $nama => $aksi) {
    try {
        $aksi();
    } catch (InvalidArgumentException $e) {
        echo $nama . " -> Ditolak: " . $e->getMessage() . "<br>";
    }
}
echo "Stok akhir tetap: " . $b->getStok();
