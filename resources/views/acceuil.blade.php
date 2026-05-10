@extends('layouts._pageLayout')

@section('content')

{{-- ═══════════════════ HERO SECTION ═══════════════════ --}}
<section class="hero-section position-relative overflow-hidden">
    <div class="hero-bg"></div>
    <div class="container position-relative" style="z-index:2">
        <div class="row align-items-center min-vh-75 py-5">
            <div class="col-lg-6 text-white">
                <span class="badge bg-primary bg-opacity-25 text-primary-light px-3 py-2 mb-3 rounded-pill">📚 Plateforme de Gestion de Bibliothèque</span>
                <h1 class="display-3 fw-900 mb-4 hero-title">
                    Votre savoir,<br>
                    <span class="text-gradient">à portée de main.</span>
                </h1>
                <p class="fs-5 text-white-50 mb-4 pe-lg-5">
                    Gérez vos emprunts, découvrez de nouveaux livres et accédez à un catalogue riche et diversifié — le tout depuis une plateforme moderne et intuitive.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-5 rounded-pill shadow-lg btn-glow">
                            <i class="bi bi-speedometer2 me-2"></i>Mon Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-5 rounded-pill shadow-lg btn-glow">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4 rounded-pill">
                            <i class="bi bi-person-plus me-2"></i>S'inscrire
                        </a>
                    @endauth
                    <a href="{{ route('livres.index') }}" class="btn btn-outline-light btn-lg px-4 rounded-pill">
                        <i class="bi bi-book me-2"></i>Catalogue
                    </a>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block text-center">
                <div class="hero-visual">
                    <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=800&auto=format&fit=crop"
                         class="img-fluid rounded-4 shadow-lg hero-img" alt="Bibliothèque">
                    <div class="floating-card card-1">
                        <div class="d-flex align-items-center gap-2">
                            <div class="icon-circle bg-success"><i class="bi bi-check-lg text-white"></i></div>
                            <div>
                                <div class="fw-bold small">Emprunt validé</div>
                                <div class="text-muted" style="font-size:11px">Il y a 2 min</div>
                            </div>
                        </div>
                    </div>
                    <div class="floating-card card-2">
                        <div class="text-center">
                            <div class="fs-3 fw-900 text-primary">{{ $totalLivres }}</div>
                            <div class="text-muted small">Livres disponibles</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════ STATS ANIMÉES ═══════════════════ --}}
<section class="py-5" style="margin-top:-40px; position:relative; z-index:3;">
    <div class="container">
        <div class="row g-4 justify-content-center">
            @php
                $stats = [
                    ['icon' => 'bi-book-fill', 'value' => $totalLivres, 'label' => 'Livres', 'color' => '#3b82f6', 'bg' => 'rgba(59,130,246,0.1)'],
                    ['icon' => 'bi-people-fill', 'value' => $totalAdherents, 'label' => 'Adhérents', 'color' => '#10b981', 'bg' => 'rgba(16,185,129,0.1)'],
                    ['icon' => 'bi-bookmark-star-fill', 'value' => $totalEmprunts, 'label' => 'Emprunts', 'color' => '#f59e0b', 'bg' => 'rgba(245,158,11,0.1)'],
                    ['icon' => 'bi-tags-fill', 'value' => $totalThemes, 'label' => 'Thèmes', 'color' => '#8b5cf6', 'bg' => 'rgba(139,92,246,0.1)'],
                ];
            @endphp
            @foreach($stats as $s)
            <div class="col-6 col-md-3">
                <div class="stat-card text-center p-4 rounded-4 shadow-sm bg-white">
                    <div class="stat-icon-wrap mx-auto mb-3" style="background:{{ $s['bg'] }}; color:{{ $s['color'] }}">
                        <i class="bi {{ $s['icon'] }} fs-3"></i>
                    </div>
                    <h2 class="fw-900 mb-0 counter" data-target="{{ $s['value'] }}">0</h2>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">{{ $s['label'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════ LIVRES POPULAIRES ═══════════════════ --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-2">🔥 Tendances</span>
            <h2 class="display-6 fw-900">Livres les plus populaires</h2>
            <p class="text-muted col-md-6 mx-auto">Découvrez les ouvrages les plus empruntés par notre communauté de lecteurs.</p>
        </div>
        <div class="row g-4">
            @foreach($livresPopulaires as $livre)
            <div class="col-md-4 col-lg-2">
                <div class="book-card rounded-4 overflow-hidden shadow-sm bg-white h-100 d-flex flex-column">
                    <div class="book-cover position-relative overflow-hidden" 
                         style="height: 180px; @if(!$livre->couverture) background: linear-gradient(135deg, {{ ['#1e3a8a','#7c3aed','#059669','#dc2626','#d97706','#0891b2'][$loop->index % 6] }} 0%, {{ ['#3b82f6','#a78bfa','#34d399','#f87171','#fbbf24','#22d3ee'][$loop->index % 6] }} 100%); @endif">
                        @if($livre->couverture)
                            <img src="{{ asset('storage/' . $livre->couverture) }}" class="w-100 h-100 object-fit-cover" alt="{{ $livre->titre }}">
                        @else
                            <div class="book-emoji">📖</div>
                        @endif
                        <div class="book-badge">{{ $livre->emprunts_count }} emprunts</div>
                    </div>
                    <div class="p-3 flex-grow-1 d-flex flex-column">
                        <h6 class="fw-bold mb-1 text-truncate" title="{{ $livre->titre }}">{{ $livre->titre }}</h6>
                        <small class="text-muted d-block mb-2">{{ $livre->auteur }}</small>
                        <div class="mt-auto">
                            <span class="badge bg-light text-dark border small">{{ $livre->theme->intitule ?? '' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('livres.index') }}" class="btn btn-primary btn-lg rounded-pill px-5 shadow">
                <i class="bi bi-grid me-2"></i>Voir tout le catalogue
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════ THÈMES / CATÉGORIES ═══════════════════ --}}
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-purple bg-opacity-10 text-purple px-3 py-2 rounded-pill mb-2">📂 Catégories</span>
            <h2 class="display-6 fw-900">Explorez par thème</h2>
        </div>
        <div class="row g-3 justify-content-center">
            @foreach($themes as $theme)
            <div class="col-auto">
                <a href="{{ route('livres.index', ['themeSel' => $theme->id]) }}" class="theme-pill d-flex align-items-center gap-2 text-decoration-none">
                    <span class="theme-count">{{ $theme->livres_count }}</span>
                    <span>{{ $theme->intitule }}</span>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════ FONCTIONNALITÉS ═══════════════════ --}}
<section class="py-5 bg-dark text-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-6 fw-900">Comment ça marche ?</h2>
            <p class="text-white-50">En 3 étapes simples</p>
        </div>
        <div class="row g-4">
            @php
                $steps = [
                    ['icon' => '🔍', 'title' => 'Parcourez le catalogue', 'desc' => 'Explorez des centaines de livres classés par thème, auteur et disponibilité.'],
                    ['icon' => '📝', 'title' => 'Réservez en un clic', 'desc' => 'Faites votre demande de réservation directement depuis la fiche du livre.'],
                    ['icon' => '📚', 'title' => 'Récupérez à la biblio', 'desc' => 'L\'admin valide votre demande. Passez récupérer votre livre et bonne lecture !'],
                ];
            @endphp
            @foreach($steps as $i => $step)
            <div class="col-md-4">
                <div class="step-card text-center p-4 rounded-4 h-100">
                    <div class="step-number">{{ $i + 1 }}</div>
                    <div class="step-icon mb-3">{{ $step['icon'] }}</div>
                    <h5 class="fw-bold mb-3">{{ $step['title'] }}</h5>
                    <p class="text-white-50 mb-0">{{ $step['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════ CTA ═══════════════════ --}}
<section class="py-5">
    <div class="container">
        <div class="cta-card text-center text-white p-5 rounded-4">
            <h2 class="display-6 fw-900 mb-3">Prêt à commencer ?</h2>
            <p class="fs-5 text-white-50 mb-4">Rejoignez notre communauté de lecteurs et accédez à un catalogue riche et diversifié.</p>
            <div class="d-flex gap-3 justify-content-center">
                @auth
                    <a href="{{ route('livres.index') }}" class="btn btn-light btn-lg px-5 rounded-pill fw-bold shadow">
                        <i class="bi bi-book me-2"></i>Explorer le catalogue
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 rounded-pill fw-bold shadow">
                        <i class="bi bi-person-plus me-2"></i>Créer mon compte
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4 rounded-pill">
                        Se connecter
                    </a>
                @endauth
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════ STYLES ═══════════════════ --}}
<style>
    .fw-900 { font-weight: 900; }
    .min-vh-75 { min-height: 75vh; }

    /* HERO */
    .hero-section { background: #0f172a; position: relative; overflow: hidden; }
    .hero-bg {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: radial-gradient(circle at 70% 50%, rgba(37,99,235,0.15), transparent 50%),
                    radial-gradient(circle at 30% 80%, rgba(124,58,237,0.1), transparent 40%);
    }
    .hero-title { line-height: 1.1; }
    .text-gradient {
        background: linear-gradient(135deg, #60a5fa, #a78bfa, #f472b6);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .text-primary-light { color: #93c5fd !important; }
    .btn-glow { box-shadow: 0 0 30px rgba(59,130,246,0.4); }
    .hero-visual { position: relative; }
    .hero-img { max-height: 450px; object-fit: cover; width: 100%; }
    .floating-card {
        position: absolute; background: white; padding: 14px 18px; border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15); animation: float 3s ease-in-out infinite;
    }
    .card-1 { bottom: 30px; left: -30px; animation-delay: 0s; }
    .card-2 { top: 30px; right: -20px; animation-delay: 1.5s; }
    @keyframes float {
        0%,100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .icon-circle { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }

    /* STATS */
    .stat-card { transition: transform 0.3s, box-shadow 0.3s; border: 1px solid #f1f5f9; }
    .stat-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(0,0,0,0.1); }
    .stat-icon-wrap {
        width: 64px; height: 64px; border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
    }

    /* BOOKS */
    .book-card { transition: transform 0.3s; border: 1px solid #f1f5f9; }
    .book-card:hover { transform: translateY(-6px); }
    .book-cover {
        height: 160px; display: flex; flex-direction: column;
        align-items: center; justify-content: center; position: relative;
    }
    .book-emoji { font-size: 48px; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2)); }
    .book-badge {
        position: absolute; bottom: 8px; right: 8px;
        background: rgba(255,255,255,0.9); padding: 2px 8px; border-radius: 20px;
        font-size: 11px; font-weight: 700; color: #1e293b;
    }

    /* THEMES */
    .theme-pill {
        background: white; border: 1px solid #e2e8f0; padding: 10px 20px;
        border-radius: 50px; font-weight: 600; color: #334155;
        transition: all 0.3s;
    }
    .theme-pill:hover { background: #2563eb; color: white; border-color: #2563eb; transform: translateY(-2px); }
    .theme-pill:hover .theme-count { background: rgba(255,255,255,0.2); color: white; }
    .theme-count {
        background: #f1f5f9; padding: 2px 10px; border-radius: 20px;
        font-size: 12px; font-weight: 800; color: #2563eb; transition: all 0.3s;
    }
    .bg-purple { background: rgba(139,92,246,0.1); }
    .text-purple { color: #7c3aed; }

    /* STEPS */
    .step-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); transition: transform 0.3s; position: relative; }
    .step-card:hover { transform: translateY(-6px); background: rgba(255,255,255,0.08); }
    .step-number {
        position: absolute; top: 16px; right: 16px;
        font-size: 48px; font-weight: 900; color: rgba(255,255,255,0.05);
    }
    .step-icon { font-size: 48px; }

    /* CTA */
    .cta-card { background: linear-gradient(135deg, #1e3a8a, #7c3aed); }
</style>

{{-- ═══════════════════ COUNTER ANIMATION ═══════════════════ --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const counters = document.querySelectorAll('.counter');
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = +el.getAttribute('data-target');
                const duration = 2000;
                const step = target / (duration / 16);
                let current = 0;
                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) { el.textContent = target; clearInterval(timer); }
                    else { el.textContent = Math.floor(current); }
                }, 16);
                observer.unobserve(el);
            }
        });
    }, { threshold: 0.5 });
    counters.forEach(c => observer.observe(c));
});
</script>

@endsection