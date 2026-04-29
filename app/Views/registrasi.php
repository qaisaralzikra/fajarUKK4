<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Modern Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #a855f7;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Background Mesh Gradient yang Keren */
            background-color: #e5e7eb;
            background-image: 
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
            background-attachment: fixed;
        }

        .login-container {
            position: relative;
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            color: white;
        }

        .login-header h2 {
            font-weight: 600;
            letter-spacing: -1px;
            margin-bottom: 5px;
        }

        .login-header p {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 30px;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.9);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 12px 15px;
            color: white;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2);
            color: white;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            color: white;
            margin-top: 10px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.5);
            color: white;
        }

        .alert-custom {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            border-radius: 12px;
            font-size: 0.85rem;
        }

        /* Hiasan Lingkaran di Background */
        .circle {
            position: absolute;
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            z-index: -1;
            filter: blur(30px);
            opacity: 0.5;
        }
        .circle-1 { top: -20px; right: -20px; }
        .circle-2 { bottom: -20px; left: -20px; }
    </style>
</head>
<body>

<div class="login-container">
    <div class="circle circle-1"></div>
    <div class="circle circle-2"></div>
    
    <div class="glass-card">
        <div class="login-header text-center">
            <h2>Registrasi Account</h2>
            <p>Aplikasi Peminjaman Buku Digital</p>
        </div>

        <?php if(session()->getFlashdata('msg')): ?>
            <div class="alert alert-custom text-center mb-4">
                <?= session()->getFlashdata('msg') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('registrasi'); ?>" enctype="multipart/form-data" method="post">
                <!-- <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" id="">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div> -->
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Username" required autocomplete="off">
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="ttl" class="form-control" placeholder="Tanggal, Bulan, Tahun" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Foto</label>
                    <input type="file" name="cover" class="form-control" id="coverInput" accept="image/*" onchange="previewImg()">
                    <small class="text-muted">Format: jpg, png (Maks 2MB)</small>
                    <div class="text-center">
                        <img id="imgPreview" class="img-preview img-thumbnail mx-auto">
                    </div>
                </div>
                <button type="submit" class="btn btn-login w-100">Sign Up</button>
            </form>
        
        <div class="text-center mt-4">
            <small style="color: rgba(255,255,255,0.5)">© 2024 Library System</small>
        </div>
    </div>
</div>

<script>
        // Fungsi untuk preview gambar saat dipilih
        function previewImg() {
            const input = document.querySelector('#coverInput');
            const preview = document.querySelector('#imgPreview');

            preview.style.display = 'block';

            const fileReader = new FileReader();
            fileReader.readAsDataURL(input.files[0]);

            fileReader.onload = function(e) {
                preview.src = e.target.result;
            }
        }
    </script>

</body>
</html>