<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - SIMBA</title>
  <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
  <div class="container active">
    <div class="form-box login">
        <div class="logo-container">
            <img src="{{ asset('assets/img/Logo Institut Teknologi Del.png') }}" alt="Logo IT Del" class="logo">
            <div class="logo-text">
                <h2>Sistem Informasi <br>Manajemen Bimbingan<br>Mahasiswa dan Perwalian<br><span>(SIMBA)</span></h2>
            </div>
        </div>
    </div>

    <div class="form-box">
        <div class="logo-container">
            <img src="{{ asset('assets/img/Logo Institut Teknologi Del.png') }}" alt="Logo IT Del" class="logo">
            <div class="logo-text">
                <h2>Sistem Informasi <br>Manajemen Bimbingan<br>Mahasiswa dan Perwalian<br><span>(SIMBA)</span></h2>
            </div>
        </div>
    </div>

    <div class="toggle-box">
        <div class="toggle-panel toggle-right">
            <div class="btn-container">
                <button class="btn register-btn">Daftar</button>
                <button class="btn login-btn">Masuk</button>
            </div>
            <form action="{{ route('register.submit') }}" method="POST">
                @csrf
                <div class="input-box">
                    <i class="bx bxs-user log"></i>
                    <label for="username">Nama Pengguna</label>
                    <input class="log" type="text" id="username" name="username" required>
                </div>
                <div class="input-box">
                    <i class="bx bxs-lock-alt log"></i>
                    <label for="password">Kata Sandi</label>
                    <input class="log" type="password" id="password" name="password" required>
                </div>
                <p>Belum Punya Akun? <a href="#" class="register-link" onclick="document.querySelector('.register-btn').click(); return false;">Daftar Disini</a></p>
                <button type="submit" class="btn">Masuk</button>
            </form>
        </div>

        <div class="toggle-panel toggle-left">
            <div class="btn-container">
                <button class="btn register-btn">Daftar</button>
                <button class="btn login-btn">Masuk</button>
            </div>
            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <div class="input-box">
                    <label for="username">Nama Pengguna</label>
                    <input class="reg" type="text" id="username" name="username" required>
                    <i class="bx bxs-user reg"></i>
                </div>
                <div class="input-box reg">
                    <label for="password">Kata Sandi</label>
                    <input class="reg" type="password" id="password" name="password" required>
                    <i class="bx bxs-lock-alt reg"></i>
                </div>
                <div class="input-box">
                    <label for="role">Jabatan</label>
                    <select id="role" required>
                      <option value="" disabled selected>Pilih Jabatan</option>
                      <option value="admin">Admin (Kemahasiswaan dan DIRDIK Konselor)</option>
                      <option value="keasramaan">Keasramaan</option>
                      <option value="dosen">Dosen Wali</option>
                      <option value="mahasiswa">Mahasiswa</option>
                      <option value="orangtua">Orangtua</option>
                    </select>
                    <i class="bx bx-chevron-down jabatan"></i>
                </div>
                <p>Sudah Daftar? <a href="#" class="login-link" onclick="document.querySelector('.login-btn').click(); return false;">Masuk Disini</a></p>
                <button type="submit" class="btn">Buat Akun</button>
            </form>
        </div>
    </div>
</div>

  </div>

  <script>
document.addEventListener("DOMContentLoaded", function () {
    const container = document.querySelector(".container");

    // Tambahkan class no-transition untuk mencegah semua transisi saat halaman pertama kali dimuat
    container.classList.add("no-transition");

    // Ambil state aktif dari sessionStorage
    const currentState = sessionStorage.getItem("activeSection");
    const isActive = currentState === "register"; // True jika di state "register"

    // Langsung perbarui tampilan sesuai state tanpa transisi
    if (isActive) {
        container.classList.remove("active");
    } else {
        container.classList.add("active");
    }

    // Tunggu sebentar sebelum menghapus no-transition untuk memastikan tidak ada transisi awal
    setTimeout(() => container.classList.remove("no-transition"), 100);
    
    // Tambahkan event listener untuk tombol toggle
    document.querySelectorAll(".register-btn").forEach(button => {
        button.addEventListener("click", () => {
            container.classList.remove("active");
            sessionStorage.setItem("activeSection", "register");
        });
    });

    document.querySelectorAll(".login-btn").forEach(button => {
        button.addEventListener("click", () => {
            container.classList.add("active");
            sessionStorage.setItem("activeSection", "login");
        });
    });
});
</script>



</body>

</html>