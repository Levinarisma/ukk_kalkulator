<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kalkulator | UKK PPLG 2025</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
       
        .logo {
            width: 150px;
            max-width: 100%;
            height: auto;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<?php
session_start();
$hasil = null;
$angka1Value = ''; // Inisialisasi input angka1 kosong

// Cek jika tombol ME ditekan
if (isset($_POST['memory']) && isset($_SESSION['memory'])) {
    $angka1Value = $_SESSION['memory'];
} else {
    // Jika bukan ME, dan ada memory, gunakan sebagai default
    $angka1Value = isset($_SESSION['memory']) ? $_SESSION['memory'] : '';
}

// Jika ada perhitungan
if (isset($_POST['operator']) && isset($_POST['angka1']) && isset($_POST['angka2'])) {
    $angka1 = $_POST['angka1'];
    $angka2 = $_POST['angka2'];
    $operator = $_POST['operator'];

    // Validasi input harus angka dengan koma sebagai desimal
    if (!preg_match('/^-?\d+([,]\d+)?$/', $angka1) || !preg_match('/^-?\d+([,]\d+)?$/', $angka2)) {
        echo "<script>alert('Input harus berupa angka dengan koma sebagai desimal')</script>";
    } elseif ($operator == '/' && str_replace(',', '.', $angka2) == 0) {
        echo "<script>alert('Tidak dapat membagi dengan nol')</script>";
    } else {
        // Ubah koma jadi titik
        $angka1F = floatval(str_replace(',', '.', $angka1));
        $angka2F = floatval(str_replace(',', '.', $angka2));

        // Proses operasi
        switch ($operator) {
            case '+': 
                $hasil = $angka1F + $angka2F; 
                break;
            case '-':
                 $hasil = $angka1F - $angka2F;
                  break;
            case '*':
                 $hasil = $angka1F * $angka2F;
                  break;
            case '/': 
                $hasil = $angka1F / $angka2F; 
                break;
$formatted_hasil = (floor($hasil)== $hasil)? number_format($hasil,0,',','.'): rtrim(rtrim(number_format($hasil,5,',','.'), '0'),',');
    }

        // Simpan ke session untuk ME
        $_SESSION['memory'] = str_replace('.', ',', $hasil);
        $angka1Value = $_SESSION['memory']; // Tampilkan hasil sebagai nilai angka pertama juga
    }
}

// Jika tombol MC ditekan
if (isset($_POST['resetmemory'])) {
    unset($_SESSION['memory']);
    $angka1Value = '';
}
?>

<div class="container mt-5">
    <div class="text-center mb-4">
        <img src="logo.png" alt="logo" class="logo">
    </div>
    <h2 class="text-center">Kalkulator</h2>

    <div class="row justify-content-center">
        <div class="col-md-4">
            <form method="POST" class="p-2 border rounded bg-light">
                <label class="form-label">Angka Pertama</label>
                <input type="text" name="angka1" class="form-control" value="<?php echo $angka1Value; ?>" required>

                <label class="form-label">Angka Kedua</label>
                <input type="text" name="angka2" class= required>

                <div class="d-flex justify-content-center gap-2 mt-2">
                    <button type="submit" class="btn btn-primary" name="operator" value="+" title="Tambah"><i class="fas fa-plus"></i></button>
                    <button type="submit" class="btn btn-success" name="operator" value="*" title="Kali"><i class="fas fa-xmark"></i></button>
                    <button type="submit" class="btn btn-info" name="operator" value="/" title="Bagi"><i class="fas fa-divide"></i></button>
                    <button type="reset" class="btn btn-warning" title="Clear Entry">CE</button>
                    <button type="submit" class="btn btn-secondary" name="operator" value="-" title="Kurang"><i class="fas fa-minus"></i></button>
                </div>
            </form>

            <div class="p-2 border rounded bg-light mt-3">
                <h4 class="text-center">
                    <?php
                    if ($hasil !== null) {
                        echo str_replace('.', ',', $angka1F) . " $operator " . str_replace('.', ',', $angka2F) . " = " . str_replace('.', ',', $hasil);
                    } else {
                        echo "Hasil: ";
                    }
                    ?>
                </h4>

                <div class="row mt-2">
                    <div class="col-6 text-end">
                        <?php if ($hasil !== null): ?>
                        <form method="POST">
                            <button type="submit" name="memory" class="btn btn-info" title="Memory Entry">ME</button>
                        </form>
                        <?php endif; ?>
                    </div>
                    <div class="col-6 text-start">
                        <?php if (isset($_SESSION['memory'])): ?>
                        <form method="POST">
                            <button type="submit" name="resetmemory" class="btn btn-danger" title="Memory Clear">MC</button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<p class="text-center mt-4"> UKK 2025 | LEVINA RISMA | PPLG</p>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
