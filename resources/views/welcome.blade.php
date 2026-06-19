<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Filhos do Vazio API</title>
        <meta name="description" content="API oficial do Filhos do Vazio, um RPG de mesa inspirado em Hollow Knight.">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Cinzel+Decorative:wght@700;900&family=IM+Fell+DW+Pica:ital@0;1&display=swap" rel="stylesheet">

        <style>
            :root {
                --hk-void:       #08090f;
                --hk-abyss:      #0b0d18;
                --hk-deep:       #0f1222;
                --hk-soul:       #4a9eff;
                --hk-soul-light: #6ab5ff;
                --hk-soul-pale:  #a0ceff;
                --hk-ghost:      #e8f0ff;
                --hk-gold:       #d4a843;
                --hk-gold-light: #e8c060;
                --hk-pale:       #d8e4f8;
                --hk-dim:        #7a8aaa;
            }

            * { box-sizing: border-box; }

            html, body {
                margin: 0;
                min-height: 100%;
            }

            body {
                background: var(--hk-void);
                color: var(--hk-pale);
                font-family: 'IM Fell DW Pica', Georgia, serif;
                color-scheme: dark;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                padding: 2rem 1.5rem;
                text-align: center;
            }

            main {
                max-width: 36rem;
            }

            .soul-mark {
                margin: 0 auto 1.5rem;
                display: block;
            }

            h1 {
                font-family: 'Cinzel Decorative', serif;
                font-weight: 700;
                font-size: clamp(1.75rem, 5vw, 2.5rem);
                color: var(--hk-ghost);
                text-shadow:
                    0 0 6px  rgba(74, 158, 255, 0.9),
                    0 0 20px rgba(74, 158, 255, 0.55),
                    0 0 45px rgba(74, 158, 255, 0.25);
                margin: 0 0 0.5rem;
            }

            .subtitle {
                font-family: 'Cinzel', serif;
                font-size: 0.7rem;
                letter-spacing: 0.35em;
                text-transform: uppercase;
                color: var(--hk-gold);
                text-shadow: 0 0 8px rgba(212, 168, 67, 0.4);
                margin: 0 0 2rem;
            }

            .hk-divider {
                display: flex;
                align-items: center;
                gap: 1rem;
                color: var(--hk-gold);
                opacity: 0.6;
                margin: 2rem 0;
            }
            .hk-divider::before,
            .hk-divider::after {
                content: '';
                flex: 1;
                height: 1px;
                background: linear-gradient(to right, transparent, var(--hk-gold));
            }
            .hk-divider::after { background: linear-gradient(to left, transparent, var(--hk-gold)); }

            p.lead {
                font-style: italic;
                color: rgba(216, 228, 248, 0.7);
                line-height: 1.85;
                letter-spacing: 0.015em;
                font-size: 1.05rem;
                margin: 0 0 1rem;
            }

            .soon {
                display: inline-flex;
                align-items: center;
                gap: 0.55rem;
                font-family: 'Cinzel', serif;
                font-size: 0.75rem;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                padding: 0.6rem 1.6rem;
                border-radius: 8px;
                border: 1px solid rgba(74, 158, 255, 0.45);
                color: var(--hk-soul-pale);
                background: rgba(74, 158, 255, 0.1);
                box-shadow: 0 1px 6px rgba(74, 158, 255, 0.2);
            }

            footer {
                margin-top: 2.5rem;
                font-size: 0.7rem;
                color: var(--hk-dim);
                letter-spacing: 0.05em;
            }
        </style>
    </head>
    <body>
        <main>
            <svg class="soul-mark" width="40" height="40" viewBox="0 0 32 32" fill="none" aria-hidden="true">
                <circle cx="16" cy="16" r="14" fill="rgba(11,13,24,0.8)" stroke="rgba(74,158,255,0.4)" stroke-width="1" />
                <ellipse cx="16" cy="16" rx="5" ry="7" fill="none" stroke="rgba(74,158,255,0.7)" stroke-width="1.4" />
                <path d="M16 6 C16 6, 13 11, 16 14 C19 11, 16 6, 16 6Z" fill="rgba(74,158,255,0.5)" />
                <circle cx="16" cy="16" r="2.2" fill="rgba(74,158,255,0.9)" />
            </svg>


            <h1>Filhos do Vazio API</h1>
            <p class="subtitle">API que sustenta as sombras de Véspera</p>

            <div class="hk-divider" aria-hidden="true">&#9670;</div>
            <p class="lead">
                Backend do RPG de mesa Filhos do Vazio.
            </p>

            <div class="hk-divider" aria-hidden="true">&#9670;</div>

           
            <footer>
                © {{ date('Y') }} Filhos do Vazio — Projeto de fãs não oficial inspirado em Hollow Knight (Team Cherry).
            </footer>
        </main>
    </body>
</html>
