<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PT ALFA SCORPII</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS untuk memposisikan form login di tengah layar */
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
            max-width: 450px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            overflow: hidden;
        }

        .card-body {
            padding: 3rem;
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
            font-size: 16px;
            border: 1px solid #ccc;
            margin-bottom: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #ff7e5f;
            box-shadow: 0 0 8px rgba(255, 126, 95, 0.5);
        }

        .btn-primary {
            background-color: #ff0000;
            border-color: #830000;
            padding: 10px;
            border-radius: 50px;
            font-size: 16px;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #740000;
            border-color: #920000;
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
            <h2 class="text-center">Silahkan Login</h2>
            <!-- Form Login -->
            <form method="POST" action="{{ route('login.data') }}">
                @csrf
                <div class="form-group">
                    <label for="kode_dealer">Kode Dealer</label>
                    <input type="text" name="kode_dealer" id="kode_dealer" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Login</button>
            </form>

        </div>
    </div>

    <!-- Bootstrap JS, jQuery, Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
