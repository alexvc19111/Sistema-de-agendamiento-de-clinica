<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-6 rounded shadow-md w-full max-w-sm">
        <h1 class="text-xl font-bold mb-4">Iniciar Sesión</h1>
        <form id="loginForm">
            <input type="text" name="username" placeholder="Usuario" class="w-full mb-3 p-2 border rounded" required>
            <input type="password" name="password" placeholder="Contraseña" class="w-full mb-3 p-2 border rounded" required>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Entrar</button>
        </form>
        <p id="errorMsg" class="text-red-500 mt-2 hidden">Credenciales inválidas</p>
    </div>

    <script>
        const loginForm = document.getElementById('loginForm');
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(loginForm);
            const data = {
                username: formData.get('username'),
                password: formData.get('password')
            };
            try {
                const res = await fetch('/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(data)
                });
                if (!res.ok) throw new Error('Login fallido');
                const json = await res.json();
                localStorage.setItem('token', json.token);
                window.location.href = '/home';
            } catch (err) {
                document.getElementById('errorMsg').classList.remove('hidden');
            }
        });
    </script>
</body>
</html>
