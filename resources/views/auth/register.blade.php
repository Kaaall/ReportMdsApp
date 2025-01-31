<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PT ALFA SCORPII</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS untuk memposisikan form registrasi di tengah layar */
        html,
        body {
            height: 100%;
            min-height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #ff3300, #000000);
            background-size: cover;
            background-attachment: fixed;
            background-blend-mode: normal;
        }

        .card {
            width: 100%;
            max-width: 500px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            overflow: hidden;
        }

        .card-body {
            padding: 2.5rem;
            background-color: #fff;
            border-radius: 15px;
        }

        .form-group label {
            font-weight: 600;
            font-size: 14px;
            color: #333;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            font-size: 20px;
            border: 1px solid #ccc;
            margin-bottom: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #ff7e5f;
            box-shadow: 0 0 8px rgba(255, 126, 95, 0.5);
        }

        .btn-primary {
            background-color: #ff7e5f;
            border-color: #ff7e5f;
            padding: 12px;
            border-radius: 50px;
            font-size: 16px;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #feb47b;
            border-color: #feb47b;
            transform: translateY(-2px);
        }

        .btn-link {
            text-decoration: none;
            color: #333;
            font-size: 14px;
        }

        .btn-link:hover {
            color: #ff7e5f;
        }

        .text-center {
            text-align: center;
        }

        h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        /* Animation for the form */
        .card-body {
            opacity: 0;
            animation: fadeIn 1s forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        /* Mobile Responsiveness */
        @media (max-width: 576px) {
            .card {
                width: 100%;
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-body">
            <h2 class="text-center">Daftar Akun Laporan</h2>
            <form method="POST" action="{{ route('register.data') }}">
                @csrf
                <div class="form-group">
                    <label for="kode_dealer">Kode Dealer</label>
                    <input type="text" name="kode_dealer" id="kode_dealer" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                        required>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="user">User</option>
                        <option value="master">Master</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="btn btn-link">Sudah memiliki akun? Login disini</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS, jQuery, Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
