{{-- ═══════════════════════════════════════════════════ --}}
{{--                VUE ADHÉRENT (GRILLE)                --}}
{{-- ═══════════════════════════════════════════════════ --}}
@if(!Auth::check() || Auth::user()->role === 'adherent')

    <div class="row g-4">
        @forelse ($db as $el)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm book-card rounded-4 overflow-hidden">
                    
                    {{-- IMAGE --}}
                    <div class="book-cover-wrapper bg-light position-relative text-center d-flex align-items-center justify-content-center overflow-hidden" style="height: 280px;">
                        @if($el->couverture)
                            <img src="{{ asset('storage/' . $el->couverture) }}" class="w-100 h-100 object-fit-cover transition-img" alt="{{ $el->titre }}">
                        @else
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center transition-img" 
                                 style="background: linear-gradient(135deg, {{ ['#1e3a8a','#7c3aed','#059669','#dc2626','#d97706','#0891b2'][$el->id % 6] }}, {{ ['#3b82f6','#a78bfa','#34d399','#f87171','#fbbf24','#22d3ee'][$el->id % 6] }});">
                                <span style="font-size: 64px; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));">📖</span>
                            </div>
                        @endif
                        
                        <div class="book-overlay d-flex align-items-center justify-content-center">
                            <a href="{{ route('livres.show',['livre'=>$el->id]) }}" class="btn btn-light btn-sm fw-bold rounded-pill px-3 shadow">
                                <i class="bi bi-eye"></i> Voir Détails
                            </a>
                        </div>

                        <div class="position-absolute top-0 end-0 m-3 z-2">
                            <span class="badge bg-primary rounded-pill shadow-sm px-3 py-2">
                                {{$el->theme->intitule}}
                            </span>
                        </div>
                    </div>

                    <div class="card-body d-flex flex-column p-4">
                        <div class="mb-auto">
                            <div class="d-flex text-warning mb-2" style="font-size: 0.8rem;">
                                @php $rating = $el->emprunts()->whereNotNull('note')->avg('note') ?: 4.5; @endphp
                                @for($i=1; $i<=5; $i++)
                                    <i class="bi bi-star{{ $i <= $rating ? '-fill' : ($i - 0.5 <= $rating ? '-half' : '') }}"></i>
                                @endfor
                                <span class="text-muted ms-2">({{ number_format($rating, 1) }})</span>
                            </div>
                            <h5 class="fw-bold text-dark mb-1 text-truncate" title="{{$el->titre}}">{{$el->titre}}</h5>
                            <p class="text-muted small mb-3"><i class="bi bi-person me-1"></i> {{$el->auteur}}</p>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="badge {{ $el->nbExemplaire > 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} px-2 py-1 border border-opacity-10">
                                @if($el->nbExemplaire > 0)
                                    <i class="bi bi-check-circle me-1"></i> {{ $el->nbExemplaire }} disponible(s)
                                @else
                                    <i class="bi bi-x-circle me-1"></i> Indisponible
                                @endif
                            </span>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('livres.show',['livre'=>$el->id]) }}" class="btn btn-light w-50 fw-bold border btn-sm py-2">Détails</a>
                            @auth
                                @if($el->nbExemplaire > 0)
                                    <a href="{{ route('emprunts.create', ['livre_id' => $el->id]) }}" class="btn btn-primary w-50 fw-bold btn-sm py-2 shadow-sm">Réserver</a>
                                @else
                                    <button disabled class="btn btn-secondary w-50 fw-bold btn-sm py-2 opacity-50">Rupture</button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-primary w-50 fw-bold btn-sm py-2">Connexion</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" alt="No books" width="100" class="mb-3 opacity-25">
                <h5 class="text-muted">Aucun livre ne correspond à votre recherche.</h5>
            </div>
        @endforelse
    </div>

@else
{{-- ═══════════════════════════════════════════════════ --}}
{{--                 VUE ADMIN (TABLEAU)                 --}}
{{-- ═══════════════════════════════════════════════════ --}}
    <div class="premium-card">
        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3 text-muted small fw-bold text-uppercase">#</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase">Titre</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase">Auteur</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase">Stock</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase">Thème</th>
                        <th class="px-4 py-3 text-muted small fw-bold text-uppercase text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($db as $el)
                        <tr>
                            <td class="px-4 fw-bold text-muted">{{$el->id}}</td>
                            <td class="fw-bold text-dark">{{$el->titre}}</td>
                            <td class="text-muted small">{{$el->auteur}}</td>
                            <td>
                                <span class="badge {{ $el->nbExemplaire > 0 ? 'bg-success' : 'bg-danger' }} rounded-pill px-3 py-1 shadow-sm">
                                    {{$el->nbExemplaire}} dispo
                                </span>
                            </td>
                            <td><span class="badge bg-secondary rounded-pill px-3 py-1">{{$el->theme->intitule}}</span></td>
                            <td class="px-4 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('livres.show',$el->id) }}" class="btn btn-sm btn-light border" title="Voir"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('livres.edit',$el->id) }}" class="btn btn-sm btn-light border text-warning" title="Modifier"><i class="bi bi-pencil"></i></a>
                                    <a href="{{ route('livres.show',['livre'=>$el->id, 'sup'=>1]) }}" class="btn btn-sm btn-light border text-danger" title="Supprimer"><i class="bi bi-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4 text-muted">Aucun livre trouvé.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endif

<div class="d-flex justify-content-center mt-4">
    {{ $db->appends(request()->query())->links() }}
</div>

<style>
    .book-card { transition: all 0.3s cubic-bezier(.25,.8,.25,1); }
    .book-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .book-overlay { position: absolute; top:0; left:0; width:100%; height:100%; background:rgba(15,23,42,0.5); opacity:0; transition:0.3s; z-index:1; }
    .book-card:hover .book-overlay { opacity:1; }
    .transition-img { transition: transform 0.6s ease; }
    .book-card:hover .transition-img { transform: scale(1.08); }
</style>
