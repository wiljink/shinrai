<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shinrai Realty Services - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(180deg, #000000, #1a1a1a);
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .auth-container {
            width: 400px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 0 25px rgba(255, 204, 0, 0.2);
            overflow: hidden;
            animation: fadeIn 1.2s ease-in-out;
            box-sizing: border-box;
            margin: 0 20px;
        }

        .logo-container {
            background: #000;
            text-align: center;
            padding: 25px;
        }

        .logo-container img {
            width: 150px;
        }

        .form-container {
            padding: 30px 35px;
            background: #fff;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            color: #333;
            outline: none;
            box-sizing: border-box;
        }

        .form-group input:focus {
            border-color: #f4c300;
            box-shadow: 0 0 5px rgba(244, 195, 0, 0.5);
        }

        .btn {
            width: 100%;
            background: #f4c300;
            color: #000;
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background: #ffd633;
        }

        .form-footer {
            text-align: center;
            margin-top: 10px;
            font-size: 13px;
            color: #666;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 480px) {
            .auth-container {
                width: 90%;
                margin: 0 15px;
            }

            .form-container {
                padding: 25px 25px;
            }
        }
    </style>
</head>
<body>
<div class="auth-container">
    <div class="logo-container">
        <img src="{{ asset('images/shinrai-logo.png') }}" alt="Shinrai Realty Services Logo">
    </div>

    <div class="form-container">
        <!-- Login Form Only -->
        <form id="loginForm" action="{{ route('login') }}" method="POST">
            @csrf
            {{-- ✅ STATUS MESSAGE --}}
            @if (session('status'))
                <div style="background:#e6ffed; color:#256029; border:1px solid #a3e6a3; padding:10px;
                    border-radius:8px; margin-bottom:15px; text-align:center;">
                    {{ session('status') }}
                </div>
            @endif

            {{-- ✅ Login errors --}}
            @if ($errors->any())
                <div style="background:#ffe6e6; color:#a33; border:1px solid #f5bcbc; padding:10px;
                    border-radius:8px; margin-bottom:15px; text-align:center;">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>

        <div class="form-footer">
            © {{ date('Y') }} Shinrai Realty Services. All Rights Reserved.
        </div>
    </div>
</div>
</body>
</html>
