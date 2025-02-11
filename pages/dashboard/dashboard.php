<?php
require_once '../../config/database.php';

// Query untuk statistik
$queryTotal = "SELECT COUNT(*) as total FROM mahasiswa";
$queryTotalL = "SELECT COUNT(*) as total FROM mahasiswa WHERE jenis_kelamin = 'L'";
$queryTotalP = "SELECT COUNT(*) as total FROM mahasiswa WHERE jenis_kelamin = 'P'";

$totalMhs = $conn->query($queryTotal)->fetch()['total'];
$totalL = $conn->query($queryTotalL)->fetch()['total'];
$totalP = $conn->query($queryTotalP)->fetch()['total'];

// Query untuk data mahasiswa
$limit = 8; // dikurangin karena card lebih gede
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$query = "SELECT * FROM mahasiswa ORDER BY created_at DESC LIMIT :start, :limit";
$stmt = $conn->prepare($query);
$stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();
$mahasiswa = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pages = ceil($totalMhs / $limit);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Akademik Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        dark: {
                            100: '#1a1625',
                            200: '#231f32',
                            300: '#2d2844',
                            400: '#37325c'
                        },
                        accent: {
                            purple: '#6c5dd3',
                            blue: '#4d7cfe'
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-dark-100 text-gray-100">
    <!-- Header -->
    <div class="bg-gradient-to-r from-dark-200 to-dark-300 p-8">
        <div class="container mx-auto">
            <h1 class="text-4xl font-bold text-white mb-2">Sistem Akademik Mahasiswa</h1>
            <p class="text-gray-400">Kelola data mahasiswa dengan mudah dan efisien</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-br from-dark-200 to-dark-300 rounded-xl shadow-lg p-6 border border-dark-400">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-accent-purple bg-opacity-20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-accent-purple" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-gray-400 text-sm">Total Mahasiswa</h2>
                        <p class="text-2xl font-semibold text-white"><?= $totalMhs ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-dark-200 to-dark-300 rounded-xl shadow-lg p-6 border border-dark-400">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-accent-blue bg-opacity-20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-accent-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-gray-400 text-sm">Mahasiswa Laki-laki</h2>
                        <p class="text-2xl font-semibold text-white"><?= $totalL ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-dark-200 to-dark-300 rounded-xl shadow-lg p-6 border border-dark-400">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-500 bg-opacity-20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-gray-400 text-sm">Mahasiswa Perempuan</h2>
                        <p class="text-2xl font-semibold text-white"><?= $totalP ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-gradient-to-br from-dark-200 to-dark-300 rounded-xl shadow-lg p-6 border border-dark-400">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-white">Data Mahasiswa</h1>
                <button onclick="openModal()"
                    class="bg-accent-purple hover:bg-opacity-80 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Mahasiswa
                </button>
            </div>

            <!-- Grid Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($mahasiswa as $mhs): ?>
                    <div class="bg-dark-300 rounded-lg shadow-lg p-4 hover:bg-dark-400 transition-all duration-200 border border-dark-400">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-accent-purple bg-opacity-20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-accent-purple" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-white"><?= htmlspecialchars($mhs['nama']) ?></h3>
                                <p class="text-gray-400"><?= htmlspecialchars($mhs['nim']) ?></p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm text-gray-400">
                                <span class="font-medium text-gray-300">Jurusan:</span> <?= htmlspecialchars($mhs['jurusan']) ?>
                            </p>
                            <p class="text-sm text-gray-400">
                                <span class="font-medium text-gray-300">Angkatan:</span> <?= htmlspecialchars($mhs['angkatan']) ?>
                            </p>
                        </div>
                        <div class="mt-4 flex justify-end space-x-2">
                            <a href="../edit/edit.php?id=<?= $mhs['id'] ?>"
                                class="px-3 py-1 bg-accent-blue hover:bg-blue-600 text-white rounded-md text-sm transition-colors duration-200">
                                Edit
                            </a>
                            <a href="../hapus/hapus.php?id=<?= $mhs['id'] ?>"
                                class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-md text-sm transition-colors duration-200"
                                onclick="return confirm('Yakin mau hapus data ini?')">
                                Hapus
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center mt-8">
                <?php for ($i = 1; $i <= $pages; $i++): ?>
                    <a href="?page=<?= $i ?>" class="mx-1 px-4 py-2 rounded-lg <?= $page == $i ? 'bg-accent-purple text-white' : 'bg-dark-300 text-gray-400 hover:bg-dark-400' ?> transition-colors duration-200">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="formModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center transition-opacity duration-300 opacity-0">
        <div class="bg-dark-200 p-8 rounded-xl shadow-lg w-full max-w-4xl transform transition-transform duration-300 scale-95">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-white">Tambah Mahasiswa</h2>
                <button onclick="closeModal()" class="text-gray-400 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex gap-8"> <!-- Container untuk 2 kolom -->
                <!-- Kolom Kiri - Gambar -->
                <div class="w-1/2 flex items-center justify-center">
                    <img src="../../assets/images/add-info.png" alt="Add Student" class="w-full max-w-md">
                </div>

                <!-- Kolom Kanan - Form -->
                <div class="w-1/2">
                    <form action="../tambah/proses_tambah.php" method="POST">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-400 mb-2">NIM</label>
                                <input type="text" name="nim" placeholder="Masukkan NIM" class="w-full bg-dark-300 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-accent-purple" required>
                            </div>
                            <div>
                                <label class="block text-gray-400 mb-2">Nama</label>
                                <input type="text" name="nama" placeholder="Nama lengkap" class="w-full bg-dark-300 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-accent-purple" required>
                            </div>
                            <div>
                                <label class="block text-gray-400 mb-2">Jurusan</label>
                                <input type="text" name="jurusan" placeholder="Masukkan jurusan" class="w-full bg-dark-300 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-accent-purple" required>
                            </div>
                            <div>
                                <label class="block text-gray-400 mb-2">Angkatan</label>
                                <input type="number" name="angkatan" placeholder="Tahun angkatan" class="w-full bg-dark-300 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-accent-purple" required>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-400 mb-2">Jenis Kelamin</label>
                                <div class="flex items-center justify-center space-x-8">
                                    <!-- Laki-laki -->
                                    <label class="flex flex-col items-center cursor-pointer group">
                                        <input type="radio" name="jenis_kelamin" value="L" class="peer hidden" required>
                                        <div class="p-4 bg-dark-300 rounded-xl group-hover:bg-accent-purple peer-checked:bg-accent-purple transition-colors duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 group-hover:text-white peer-checked:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z M20 4h-4v4m4-4l-5 5" />
                                            </svg>
                                        </div>
                                        <span class="mt-2 text-sm text-gray-400 group-hover:text-white peer-checked:text-accent-purple">Laki-laki</span>
                                    </label>

                                    <!-- Perempuan -->
                                    <label class="flex flex-col items-center cursor-pointer group">
                                        <input type="radio" name="jenis_kelamin" value="P" class="peer hidden" required>
                                        <div class="p-4 bg-dark-300 rounded-xl group-hover:bg-accent-purple peer-checked:bg-accent-purple transition-colors duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 group-hover:text-white peer-checked:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z M12 4v8m-4-4h8" />
                                            </svg>
                                        </div>
                                        <span class="mt-2 text-sm text-gray-400 group-hover:text-white peer-checked:text-accent-purple">Perempuan</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" onclick="closeModal()" class="px-4 py-2 bg-dark-300 text-gray-400 rounded-lg hover:bg-dark-400">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-accent-purple text-white rounded-lg hover:bg-opacity-80">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            const modal = document.getElementById('formModal');
            modal.classList.remove('hidden');
            // Trigger reflow
            modal.offsetHeight;
            modal.classList.add('flex');
            modal.classList.remove('opacity-0');
            modal.querySelector('.bg-dark-200').classList.remove('scale-95');
            modal.querySelector('.bg-dark-200').classList.add('scale-100');
        }

        function closeModal() {
            const modal = document.getElementById('formModal');
            modal.classList.add('opacity-0');
            modal.querySelector('.bg-dark-200').classList.remove('scale-100');
            modal.querySelector('.bg-dark-200').classList.add('scale-95');

            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300); // Sesuaikan dengan duration transisi
        }
    </script>
</body>

</html>
