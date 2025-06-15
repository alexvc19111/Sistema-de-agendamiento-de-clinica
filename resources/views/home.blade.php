<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="p-8 bg-gray-100 min-h-screen">
    <h1 class="text-2xl font-bold mb-4">Bienvenido al sistema</h1>
    <!-- Formulario para crear usuarios, oculto por defecto -->
         <div id="app" class="hidden">

        <form id="createUserForm" class="hidden">
            <input type="text" name="username" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
             <select name="persona_id" id="personaSelect" required>
              <option value="">Selecciona una persona</option>
            </select>
            <button type="submit">Crear Usuario</button>
        </form>
            </div>
            <br>

    <button id="logoutBtn" class="bg-red-500 text-white p-2 rounded">Cerrar sesión</button>

    <script>
        async function cargarPersonas() {
    const token = localStorage.getItem('token');
    const res = await fetch('/api/personas', {
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        }
    });
    if (!res.ok) return alert('Error al cargar personas');
    const personas = await res.json();
    const select = document.getElementById('personaSelect');
    personas.forEach(p => {
        const option = document.createElement('option');
        option.value = p.id;
        option.textContent = `${p.nombres} ${p.apellidos}`;
        select.appendChild(option);
    });
}

        async function checkAuth() {
            const token = localStorage.getItem('token');
            if (!token) return window.location.href = '/login';

            const res = await fetch('/api/me', {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });

            if (!res.ok) return window.location.href = '/login';
            const user = await res.json();
            document.getElementById('app').classList.remove('hidden');

            // Mostrar formulario solo si es Administrador
            if (user.username === 'Administrador') {
                document.getElementById('createUserForm').classList.remove('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            checkAuth();
            cargarPersonas();


            document.getElementById('logoutBtn').addEventListener('click', async () => {
                const token = localStorage.getItem('token');
                await fetch('/api/logout', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });
                localStorage.removeItem('token');
                window.location.href = '/login';
            });
            // Opcional: manejar envío del formulario para crear usuario
            document.getElementById('createUserForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                const form = e.target;
                const data = {
                    username: form.username.value,
                    password: form.password.value,
                    persona_id: form.persona_id.value
                };
                const token = localStorage.getItem('token');
                const res = await fetch('/api/usuarios', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                if (res.ok) {
                    alert('Usuario creado exitosamente');
                    form.reset();
                } else {
                    const error = await res.json();
                    alert('Error: ' + (error.mensaje || 'No se pudo crear usuario'));
                }
            });
        });
    </script>
</body>
</html>
