<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Admin</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .profile-card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            padding: 30px;
            width: 500px;
            align-items: center;
            border: 1px solid #e0e0e0;
        }

        .profile-photo {
            width: 150px;
            height: 180px;
            background-color: #e9ecef;
            border: 2px dashed #adb5bd;
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #6c757d;
            font-weight: bold;
            margin-right: 30px;
            flex-shrink: 0;
        }

        .profile-info {
            flex-grow: 1;
        }

        .info-row {
            margin-bottom: 15px;
        }

        .info-label {
            display: block;
            font-size: 12px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 18px;
            color: #333;
            font-weight: 600;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
    </style>
</head>
<body>

    <div class="profile-card">
        <div class="profile-photo">
            FOTO 3x4
        </div>

        <div class="profile-info">
            <div class="info-row">
                <span class="info-label">Nama</span>
                <div class="info-value">Administrator Utama</div>
            </div>
            
            <div class="info-row">
                <span class="info-label">Jabatan</span>
                <div class="info-value">Kepala Perpustakaan</div>
            </div>

            <div class="info-row">
                <span class="info-label">TTL</span>
                <div class="info-value">Makassar, 01 Januari 1990</div>
            </div>
        </div>
    </div>

</body>
</html>