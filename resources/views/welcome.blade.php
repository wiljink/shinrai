<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shinrai Realty Services - Welcome</title>
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

        .tab-container {
            display: flex;
            border-bottom: 2px solid #eee;
        }

        .tab {
            flex: 1;
            text-align: center;
            padding: 12px 0;
            cursor: pointer;
            font-weight: 600;
            color: #333;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .tab.active {
            color: #d90000;
            border-color: #d90000;
        }

        .form-container {
            padding: 30px 35px;
            background: #fff;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            color: #333;
            outline: none;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group select:focus {
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

            .tab {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
<div class="auth-container">
    <div class="logo-container">
        <img src="{{ asset('images/shinrai-logo.png') }}" alt="Shinrai Realty Services Logo">
    </div>

    <div class="tab-container">
        <div id="loginTab" class="tab active" onclick="showTab('login')">Log In</div>
        <div id="registerTab" class="tab" onclick="showTab('register')">Register</div>
    </div>

    <div class="form-container">
        <!-- ✅ STATUS / ERROR MESSAGES -->
        @if (session('status'))
            <div style="background:#e6ffed; color:#256029; border:1px solid #a3e6a3; padding:10px;
                        border-radius:8px; margin-bottom:15px; text-align:center;">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="background:#ffe6e6; color:#a33; border:1px solid #f5bcbc; padding:10px;
                        border-radius:8px; margin-bottom:15px; text-align:center;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <!-- ✅ END STATUS / ERROR MESSAGES -->

        <!-- Login Form -->
        <form id="loginForm" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>

        <!-- Register Form -->
        <form id="registerForm" action="{{ route('register') }}" method="POST" style="display:none;">
            @csrf
            <div class="form-group">
                <select name="role" required>
                    <option value="">Are you a?</option>
                    <option value="broker">Broker</option>
                    <option value="agent">Agent</option>
                    <option value="buyer">Buyer</option>
                </select>
            </div>
            <div class="form-group">
                <input type="text" name="first_name" placeholder="First Name" required>
            </div>
            <div class="form-group">
                <input type="text" name="last_name" placeholder="Last Name" required>
            </div>
            <div class="form-group">
                <input type="text" name="invited_by" placeholder="Invited By / Upline">
            </div>
            <div class="form-group">
                <input type="date" name="birthday" required>
            </div>
            <div class="form-group">
                <select name="gender" required>
                    <option value="">Choose Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn">Register</button>
        </form>

        <div class="form-footer">
            © {{ date('Y') }} Shinrai Realty Services. All Rights Reserved.
        </div>
    </div>
</div>

<script>
    function showTab(tab) {
        document.getElementById('loginTab').classList.remove('active');
        document.getElementById('registerTab').classList.remove('active');
        document.getElementById('loginForm').style.display = 'none';
        document.getElementById('registerForm').style.display = 'none';

        if (tab === 'login') {
            document.getElementById('loginTab').classList.add('active');
            document.getElementById('loginForm').style.display = 'block';
        } else {
            document.getElementById('registerTab').classList.add('active');
            document.getElementById('registerForm').style.display = 'block';
        }
    }
</script>
</body>
</html>
