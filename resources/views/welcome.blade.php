<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #f4f4f4;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            padding: 2rem;
            text-align: center;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #1a73e8;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            max-width: 600px;
        }

        .code-box {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin: 0.5rem 0;
        }

        code {
            background: #eee;
            padding: 6px 10px;
            border-radius: 4px;
            font-family: monospace;
        }

        button, a {
            background-color: #1a73e8;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        button:hover, a:hover {
            background-color: #0c59c5;
        }

        .footer {
            margin-top: 2rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            color: #666;
        }

        .github-link {
            margin-top: 0.5rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
<h1>📦 Inventory Management System</h1>
<p>Bienvenido a tu sistema de gestión de inventarios.</p>
<p>📁 Administra productos, 🏷️ organiza categorías y 🔐 protege el acceso mediante autenticación con roles.</p>

<div class="code-box">
    <code id="api-url">{{ url('/api') }}</code>
    <button onclick="copyToClipboard('api-url')">📋 Copiar</button>
</div>

<div class="code-box">
    <code id="doc-url">{{ url('/api/documentation') }}</code>
    <button onclick="copyToClipboard('doc-url')">📋 Copiar</button>
    <a href="{{ url('/api/documentation') }}" target="_blank" rel="noopener">📖 Ir</a>
</div>

<div class="footer">
    🧑‍💻 Desarrollado por Jonathan Guevara · Laravel {{ Illuminate\Foundation\Application::VERSION }}
</div>

<a class="github-link" href="https://github.com/memooguevara/laravel-inventory-api" target="_blank" rel="noopener">
    🌐 Ver en GitHub
</a>

<script>
    function copyToClipboard (elementId) {
        const text = document.getElementById(elementId).textContent
        navigator.clipboard.writeText(text)
            .then(() => showTooltip('✅ Copiado'))
            .catch(() => showTooltip('❌ Error al copiar'))
    }

    function showTooltip (message) {
        const tooltip = document.createElement('div')
        tooltip.textContent = message
        tooltip.style.position = 'fixed'
        tooltip.style.bottom = '20px'
        tooltip.style.left = '50%'
        tooltip.style.transform = 'translateX(-50%)'
        tooltip.style.background = '#333'
        tooltip.style.color = '#fff'
        tooltip.style.padding = '8px 16px'
        tooltip.style.borderRadius = '6px'
        tooltip.style.zIndex = 1000
        tooltip.style.opacity = 0
        tooltip.style.transition = 'opacity 0.3s'

        document.body.appendChild(tooltip)
        requestAnimationFrame(() => tooltip.style.opacity = 1)

        setTimeout(() => {
            tooltip.style.opacity = 0
            tooltip.addEventListener('transitionend', () => tooltip.remove())
        }, 2000)
    }
</script>
</body>
</html>
