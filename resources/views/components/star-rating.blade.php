@props([
    'gameId',
    'userRating' => null,
    'average' => 0,
    'count' => 0,
])

<div class="mb-2">
    <div class="d-flex align-items-center gap-2">
        <div class="star-rating"
             data-game-id="{{ $gameId }}"
             data-current="{{ (int) ($userRating ?? 0) }}">
            @for ($i = 1; $i <= 5; $i++)
                <button type="button"
                        class="star btn btn-link p-0"
                        data-value="{{ $i }}"
                        aria-label="Valorar con {{ $i }} estrellas">
                    ★
                </button>
            @endfor
        </div>

        <span class="badge bg-secondary" id="your-rating-label-{{ $gameId }}">
            Tu valoración: {{ $userRating ? $userRating.'/5' : '—' }}
        </span>
    </div>

    <div class="small text-muted mt-1">
        Promedio: <strong id="avg-label-{{ $gameId }}">{{ number_format((float)$average, 2) }}</strong>/5
        · <span id="count-label-{{ $gameId }}">{{ (int)$count }}</span> valoraciones
    </div>

    <div class="mt-2">
        <span class="small" id="feedback-{{ $gameId }}"></span>
    </div>
</div>

<style>
    .star-rating .star {
        font-size: 1.6rem;
        line-height: 1;
        text-decoration: none;
        color: #c7c7c7;
        transition: transform .08s ease-in-out, color .12s ease-in-out;
    }
    .star-rating .star:hover { transform: scale(1.08); }
    .star-rating .star.is-filled { color: #f4c150; }
    .star-rating .star:focus { outline: none; box-shadow: none; }
    .star-rating.is-disabled { opacity: .6; pointer-events: none; }
</style>

<script>
(function () {
    // Evita registrar listeners múltiples si el componente se renderiza varias veces
    if (window.__starRatingBound) return;
    window.__starRatingBound = true;

    function paintStars(container, value) {
        const stars = container.querySelectorAll('.star');
        stars.forEach(star => {
            const v = Number(star.dataset.value);
            star.classList.toggle('is-filled', v <= value);
        });
    }

    function setFeedback(gameId, text, kind) {
        const el = document.getElementById(`feedback-${gameId}`);
        if (!el) return;
        el.className = kind === 'ok' ? 'text-success small' : (kind === 'warn' ? 'text-warning small' : 'text-danger small');
        el.textContent = text;
    }

    async function submitRating(gameId, ratingValue, container) {
        container.classList.add('is-disabled');
        setFeedback(gameId, 'Guardando valoración…', 'warn');

        try {
            const res = await fetch(`{{ route('ratings.store') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ game_id: gameId, rating: ratingValue }),
            });

            const data = await res.json().catch(() => ({}));

            if (!res.ok) {
                // 401/419 etc.
                setFeedback(gameId, data.message || 'No se pudo guardar la valoración.', 'err');
                container.classList.remove('is-disabled');
                return;
            }

            // Actualizar UI
            paintStars(container, ratingValue);

            const yourLabel = document.getElementById(`your-rating-label-${gameId}`);
            if (yourLabel) yourLabel.textContent = `Tu valoración: ${ratingValue}/5`;

            if (typeof data.average !== 'undefined') {
                const avgLabel = document.getElementById(`avg-label-${gameId}`);
                if (avgLabel) avgLabel.textContent = Number(data.average).toFixed(2);
            }

            // Si devuelves count en JSON, lo actualizas aquí (opcional)
            // if (typeof data.count !== 'undefined') ...

            setFeedback(gameId, data.message || 'Valoración guardada.', 'ok');
        } catch (e) {
            setFeedback(gameId, 'Error de red al guardar la valoración.', 'err');
        } finally {
            container.classList.remove('is-disabled');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.star-rating').forEach(container => {
            const gameId = container.dataset.gameId;
            const current = Number(container.dataset.current || 0);

            // 3️⃣ Mostrar valoración actual del usuario (pintar)
            paintStars(container, current);

            // 2️⃣ Estrellas clicables
            container.querySelectorAll('.star').forEach(btn => {
                btn.addEventListener('click', () => {
                    const value = Number(btn.dataset.value);

                    @if(auth()->check())
                        submitRating(gameId, value, container); // 6️⃣ feedback visual
                    @else
                        setFeedback(gameId, 'Debes iniciar sesión para valorar.', 'warn');
                    @endif
                });

                // Hover preview (feedback visual extra)
                btn.addEventListener('mouseenter', () => paintStars(container, Number(btn.dataset.value)));
            });

            container.addEventListener('mouseleave', () => {
                // volver a la valoración real al salir
                const now = Number(container.dataset.current || 0);
                paintStars(container, now);
            });
        });
    });
})();
</script>
