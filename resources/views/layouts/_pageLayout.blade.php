<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- BOOTSTRAP --}}
    <link rel="stylesheet" href="{{ asset('./style/bootstrap.min.css') }}">

    {{-- BOOTSTRAP ICONS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    {{-- PWA --}}
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#1e3a8a">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <title>Gestion Bibliothèque</title>

    <style>
        :root {
            --bg-body: #f4f7fa;
            --bg-card: #ffffff;
            --text-main: #334155;
            --text-muted: #64748b;
            --nav-gradient: linear-gradient(90deg, #0f172a, #1e3a8a);
            --border-color: #e2e8f0;
        }

        [data-bs-theme="dark"] {
            --bg-body: #0f172a;
            --bg-card: #1e293b;
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --nav-gradient: linear-gradient(90deg, #020617, #0f172a);
            --border-color: #334155;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navbar {
            background: var(--nav-gradient);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .nav-link {
            color: white !important;
            font-weight: 500;
            transition: 0.3s;
            border-radius: 10px;
            padding: 10px 15px !important;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .user-card {
            background: var(--bg-card);
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            padding: 20px;
            margin-top: 25px;
            color: var(--text-main);
            border: 1px solid var(--border-color);
        }

        /* HIDE DROPDOWN CARET */
        .hide-caret::after {
            display: none !important;
        }

        .user-photo {
            width: 110px;
            height: 110px;
            object-fit: cover;
            border: 4px solid #2563eb;
        }

        .main-content {
            flex: 1;
        }

        footer {
            background: var(--nav-gradient);
            color: white;
        }

        .btn-custom {
            border-radius: 12px;
            padding: 10px 18px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .form-control, .form-select {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            background-color: var(--bg-body);
            color: var(--text-main);
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            background-color: var(--bg-card);
            border-color: #3b82f6;
            color: var(--text-main);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .premium-card {
            background: var(--bg-card);
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: 1px solid var(--border-color);
            overflow: hidden;
            color: var(--text-main);
        }
        
        .premium-card-header {
            background: rgba(0,0,0,0.02);
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem 2rem;
        }

        .premium-card-body {
            padding: 2rem;
        }

        .input-icon-wrapper i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        /* Dark mode toggle button */
        .theme-toggle {
            cursor: pointer;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: rgba(255,255,255,0.1);
            color: white;
            transition: 0.3s;
        }
        .theme-toggle:hover {
            background: rgba(255,255,255,0.2);
        }

        /* PREMIUM AI BUTTON */
        .btn-ai {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border: none;
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            animation: pulse-ai 2s infinite;
        }

        .btn-ai:hover {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 15px 35px rgba(139, 92, 246, 0.5);
        }

        @keyframes pulse-ai {
            0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); }
            70% { box-shadow: 0 0 0 15px rgba(59, 130, 246, 0); }
            100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
        }
    </style>

</head>

<body>

    {{-- NAVBAR --}}
    <header>

        <nav class="navbar navbar-expand-lg navbar-dark shadow-lg py-3">

            <div class="container">

                {{-- LOGO --}}
                <a class="navbar-brand" href="/">
                    📚 Gestion Bibliothèque
                </a>

                {{-- MOBILE BUTTON --}}
                <button class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarMain">

                    <span class="navbar-toggler-icon"></span>

                </button>

                {{-- NAVBAR --}}
                <div class="collapse navbar-collapse" id="navbarMain">

                    {{-- NAV LINKS --}}
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-2">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">
                                <i class="bi bi-house-door me-1"></i> Home
                            </a>
                        </li>
                        @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard">
                                <i class="bi bi-grid-1x2 me-1"></i> Dashboard
                            </a>
                        </li>
                        @endauth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('livres*') ? 'active' : '' }}" href="/livres">
                                <i class="bi bi-book me-1"></i> Livres
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('themes*') ? 'active' : '' }}" href="/themes">
                                <i class="bi bi-tags me-1"></i> Themes
                            </a>
                        </li>
                        @auth
                            @if(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('adherents*') ? 'active' : '' }}" href="/adherents">
                                    <i class="bi bi-people me-1"></i> Adhérents
                                </a>
                            </li>
                            @endif
                        @endauth
                    </ul>

                    {{-- SEARCH & AUTH --}}
                    <div class="d-flex align-items-center gap-3">
                        
                        {{-- SEARCH BAR (DESKTOP) --}}
                        <form action="{{ route('livres.index') }}" method="GET" class="d-none d-xl-block position-relative">
                            <input type="text" name="val" class="form-control form-control-sm rounded-pill px-3 border-0 bg-white bg-opacity-10 text-white" 
                                   placeholder="Rechercher..." style="width: 180px; backdrop-filter: blur(5px);">
                            <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-white opacity-50 small"></i>
                        </form>

                        {{-- THEME TOGGLE --}}
                        <div class="theme-toggle" id="themeToggle" title="Changer de thème">
                            <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
                        </div>

                        @auth
                            {{-- USER DROPDOWN --}}
                            <div class="dropdown">
                                <button class="btn btn-link nav-link d-flex align-items-center gap-2 border-0 pe-0 text-decoration-none dropdown-toggle hide-caret" 
                                        type="button" 
                                        id="userDropdown" 
                                        data-bs-toggle="dropdown" 
                                        aria-expanded="false">
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . (auth()->user()->photo ?? 'photos/default.png')) }}" 
                                             class="rounded-circle border border-2 border-white shadow-sm" 
                                             style="width: 38px; height: 38px; object-fit: cover;"
                                             onerror="this.src='{{ asset('storage/photos/default.png') }}'">
                                        <span class="position-absolute bottom-0 end-0 bg-success border border-white border-2 rounded-circle" style="width: 10px; height: 10px;"></span>
                                    </div>
                                    <div class="text-start d-none d-sm-block">
                                        <div class="fw-bold text-white small leading-none" style="margin-bottom: -2px;">{{ auth()->user()->name }}</div>
                                        <div class="text-white-50" style="font-size: 0.65rem;">{{ auth()->user()->role === 'admin' ? 'Admin' : 'Adhérent' }} <i class="bi bi-chevron-down ms-1"></i></div>
                                    </div>
                                </button>
                                
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2 mt-2" aria-labelledby="userDropdown" style="min-width: 200px;">
                                    <li>
                                        <a class="dropdown-item py-2 rounded-3 d-flex align-items-center" href="{{ route('adherents.show', auth()->id()) }}">
                                            <i class="bi bi-person-circle me-2 fs-5 text-success"></i> Mon Profil
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2 rounded-3 d-flex align-items-center" href="{{ route('adherents.edit', auth()->id()) }}">
                                            <i class="bi bi-gear-wide-connected me-2 fs-5 text-primary"></i> Paramètres
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider opacity-50"></li>
                                    <li class="px-1">
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item py-2 rounded-3 d-flex align-items-center text-danger fw-bold border-0 bg-transparent">
                                                <i class="bi bi-box-arrow-right me-2 fs-5"></i> Déconnexion
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <div class="d-flex gap-2">
                                <a class="btn btn-light btn-sm rounded-pill px-3 fw-bold" href="{{ route('login') }}">Connexion</a>
                                <a class="btn btn-warning btn-sm rounded-pill px-3 fw-bold d-none d-md-block" href="{{ route('register') }}">S'inscrire</a>
                            </div>
                        @endauth
                    </div>

                </div>

            </div>

        </nav>

    </header>

    {{-- USER INFO REMOVED AS PER USER REQUEST --}}

    {{-- CONTENT --}}
    <main class="main-content py-4">

        @yield('content')

    </main>

    {{-- CHATBOT FLOAT --}}
    <div id="chatbot-container" class="position-fixed bottom-0 end-0 m-4 z-3" style="width: 350px; display: none;">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-primary text-white p-3 d-flex justify-content-between align-items-center">
                <span class="fw-bold"><i class="bi bi-robot me-2"></i> Assistant SmartLib</span>
                <button type="button" class="btn-close btn-close-white" onclick="toggleChat()"></button>
            </div>
            <div class="card-body p-0" style="height: 350px; overflow-y: auto; background: var(--bg-body);" id="chat-messages">
                <div class="p-3 text-muted small text-center">Posez-moi une question sur la bibliothèque !</div>
            </div>
            <div class="card-footer bg-white border-0 p-2">
                <div class="input-group">
                    <input type="text" id="chat-input" class="form-control border-0 bg-light rounded-pill" placeholder="Votre message...">
                    <button class="btn btn-primary rounded-circle ms-2" onclick="sendMessage()"><i class="bi bi-send-fill"></i></button>
                </div>
            </div>
        </div>
    </div>

    <button class="btn btn-primary btn-lg rounded-circle position-fixed bottom-0 end-0 m-4 z-3 d-flex align-items-center justify-content-center btn-ai" 
            id="chatbot-toggle" onclick="toggleChat()" style="width: 70px; height: 70px;">
        <i class="bi bi-stars fs-1 text-white"></i>
    </button>

    {{-- FOOTER --}}
    <footer class="mt-auto py-4 shadow-lg">

        <div class="container">

            <div class="row align-items-center">

                <div class="col-md-6">

                    <h5 class="fw-bold">
                        📚 Gestion Bibliothèque
                    </h5>

                    <p class="mb-0">
                        Application moderne de gestion de bibliothèque avec Laravel.
                    </p>

                </div>

                <div class="col-md-6 text-md-end mt-3 mt-md-0">

                    <p class="mb-1">
                        © 2026 SmartLibrary
                    </p>

                    <small>
                        Développé avec Laravel & Bootstrap
                    </small>

                </div>

            </div>

        </div>

    </footer>

    {{-- BOOTSTRAP JS (NECESSARY FOR DROPDOWNS) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const html = document.documentElement;
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');

        function updateIcon(theme) {
            themeIcon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
        }

        function setTheme(theme) {
            html.setAttribute('data-bs-theme', theme);
            localStorage.setItem('theme', theme);
            updateIcon(theme);
        }

        // 1. Détection initiale
        const savedTheme = localStorage.getItem('theme');
        const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        if (savedTheme) {
            setTheme(savedTheme);
        } else {
            setTheme(systemDark ? 'dark' : 'light');
        }

        // 2. Écouteur de clic manuel
        themeToggle.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-bs-theme');
            setTheme(currentTheme === 'light' ? 'dark' : 'light');
        });

        // 3. Écouteur de changement système
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (!localStorage.getItem('theme')) {
                setTheme(e.matches ? 'dark' : 'light');
            }
        });

        // 4. Registration Service Worker (PWA)
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('PWA Service Worker registered !'))
                    .catch(err => console.log('SW registration failed:', err));
            });
        }

        // 5. CHATBOT LOGIC
        function toggleChat() {
            const container = document.getElementById('chatbot-container');
            const toggle = document.getElementById('chatbot-toggle');
            container.style.display = container.style.display === 'none' ? 'block' : 'none';
            toggle.style.display = container.style.display === 'none' ? 'block' : 'none';
        }

        function addMessage(text, isUser = false) {
            const container = document.getElementById('chat-messages');
            const div = document.createElement('div');
            div.className = `p-2 my-2 rounded-3 ms-2 me-2 ${isUser ? 'bg-primary text-white ms-auto' : 'bg-light text-dark me-auto'}`;
            div.style.maxWidth = '80%';
            div.style.width = 'fit-content';
            div.innerText = text;
            container.appendChild(div);
            container.scrollTop = container.scrollHeight;
        }

        function sendMessage() {
            const input = document.getElementById('chat-input');
            const msg = input.value.trim();
            if (!msg) return;

            addMessage(msg, true);
            input.value = '';

            // Simulation de réponse IA simple
            setTimeout(() => {
                let response = "Désolé, je ne comprends pas. Essayez de demander 'horaires', 'emprunt' ou 'aide'.";
                const lower = msg.toLowerCase();
                if (lower.includes('horaire')) response = "Nous sommes ouverts du Lundi au Vendredi, de 9h à 18h.";
                if (lower.includes('emprunt')) response = "Pour emprunter, allez dans le catalogue, choisissez un livre et cliquez sur 'Réserver'.";
                if (lower.includes('aide')) response = "Je peux vous aider à trouver un livre, expliquer les règles ou modifier votre profil.";
                if (lower.includes('bonjour')) response = "Bonjour ! Comment puis-je vous aider aujourd'hui ?";
                
                addMessage(response);
            }, 600);
        }

        document.getElementById('chat-input')?.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') sendMessage();
        });
    </script>
</body>

</html>