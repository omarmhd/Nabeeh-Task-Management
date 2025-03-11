<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom, #1c92d2, #f2fcfe);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background: #fff;
            width: 400px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .login-container img {
            width: 100px;
            margin-bottom: 20px;
        }

        .login-container h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }

        .login-container p {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
        }

        .login-container input {
            margin: 10px 0;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .login-container input:focus {
            border-color: #1c92d2;
        }

        .login-container button {
            background: #1c92d2;
            color: white;
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .login-container button:hover {
            background: #155e94;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #aaa;
        }

        .footer a {
            color: #1c92d2;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .error {
            color: #ff4d4d;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="login-container">
    <img src="https://cdn-icons-png.flaticon.com/512/4133/4133572.png" alt="Ticket Icon">
    <h2>Nabeeh-Task Management</h2>
    <p>Log in to access management system.</p>
    <form id="loginForm">
        <input type="email" name="email" id="email" placeholder="Email Address" required>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <div class="footer">
        <B style="color: #321d80">For Login:</B>
        <p style="color: red">test@test.com</p>
        <p style="color: red">12345678</p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#loginForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route("api.login") }}',
                type: 'POST',
                data: {
                    email: $('#email').val(),
                    password: $('#password').val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.token) {
                        localStorage.setItem('auth_token', response.token);
                        window.location.href = '{{ route("web.tasks.index") }}';
                    } else {
                        alert('Invalid credentials');
                    }
                },
                error: function() {
                    alert('Login failed.check your credentials');
                }
            });
        });
    });
</script>
</body>
</html>
