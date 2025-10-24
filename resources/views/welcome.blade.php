<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- If you have Vite/Tailwind enabled, keep it; otherwise the inline CSS will make it look good --}}
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    {{-- Small custom styles to ensure perfect centering & dark theme even without Tailwind --}}
    <style>
        :root {
            --card-bg: #111217;
            --card-border: #1d1f24;
            --muted: #9aa0a6;
            --accent: linear-gradient(90deg, #D93025 0%, #00A458 50%, #2F7ED8 100%);
            --glass: rgba(255, 255, 255, 0.03);
        }

        html,
        body {
            height: 100%;
            margin: 0;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            background: radial-gradient(1200px 600px at 10% 10%, rgba(47, 126, 216, 0.06), transparent),
                radial-gradient(900px 480px at 90% 90%, rgba(217, 48, 37, 0.03), transparent),
                #0b0b0d;
            color: #e6eef6;
        }

        .wrap {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem;
            box-sizing: border-box;
        }

        .card {
            width: 100%;
            max-width: 420px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0.01));
            border: 1px solid var(--card-border);
            box-shadow: 0 10px 30px rgba(2, 6, 23, 0.6);
            border-radius: 14px;
            padding: 32px;
            text-align: center;
            backdrop-filter: blur(6px);
        }

        .logo {
            height: 56px;
            /* smaller than before but crisp */
            width: auto;
            display: inline-block;
            margin: 0 auto 14px;
        }

        h1 {
            margin: 0 0 8px;
            font-size: 20px;
            letter-spacing: -0.3px;
            color: #f5f7fb;
        }

        p.lead {
            margin: 0 0 20px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.45;
            padding: 0 8px;
        }

        .btn {
            display: inline-flex;
            gap: 10px;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            font-weight: 600;
            letter-spacing: .2px;
            cursor: pointer;
            border: none;
            color: white;
            background: var(--accent);
            background-size: 200% 200%;
            transition: transform .15s ease, opacity .12s ease;
            box-shadow: 0 6px 18px rgba(47, 126, 216, 0.12);
        }

        .btn:active {
            transform: translateY(1px);
        }

        .btn[disabled] {
            opacity: 0.85;
            cursor: wait;
        }

        .btn.secondary {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.06);
            color: #dbe7f8;
            box-shadow: none;
        }

        .meta {
            margin-top: 16px;
            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: var(--muted);
            flex-wrap: wrap;
        }

        .meta a {
            color: var(--muted);
            text-decoration: none;
        }

        .meta a:hover {
            color: #fff;
            text-decoration: underline;
        }

        .top-right {
            position: absolute;
            right: 18px;
            top: 18px;
            display: flex;
            gap: 8px;
        }

        .link-pill {
            background: rgba(255, 255, 255, 0.02);
            padding: 6px 10px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.03);
            font-size: 13px;
            color: #dbe7f8;
            text-decoration: none;
        }

        .small {
            font-size: 11px;
            color: var(--muted);
        }

        footer.site-foot {
            text-align: center;
            margin-top: 14px;
            color: var(--muted);
            font-size: 11px;
        }

        .spinner {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.12);
            border-top-color: #ffffff;
            animation: spin .8s linear infinite;
            display: inline-block;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* small responsive tweak */
        @media (max-width:420px) {
            .card {
                padding: 22px;
                border-radius: 12px;
            }

            .logo {
                height: 48px;
            }
        }
    </style>
</head>

<body>
    <div class="wrap">

        {{-- top-right nav if routes exist --}}
        <div class="top-right" aria-hidden="true">
            @if (Route::has('login'))
                @auth
                    <a class="link-pill" href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    <a class="link-pill" href="{{ route('login') }}">Sign in</a>
                    @if (Route::has('register'))
                        <a class="link-pill" href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            @endif
        </div>

        <main class="card" role="main" aria-labelledby="page-title">
            {{-- logo --}}
            <img class="logo" src="{{ asset('zoho_logo_icon.png') }}" alt="Zoho logo" />

            <h1 id="page-title">Welcome to Zoho CRM</h1>

            <p class="lead">
                Securely connect your Zoho One account to manage CRM, events, and more — all from one place.
            </p>

            {{-- Buttons block --}}
            <div style="display:grid; gap:12px;">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn" role="button" aria-label="Go to Dashboard">
                        <span style="display:inline-block;">Go to Dashboard</span>
                    </a>
                @else
                    {{-- Primary login: points to named route 'login' (your /zoho/auth route should be named login) --}}
                    <button id="zohoLoginBtn" class="btn" type="button" aria-label="Login with Zoho"
                        onclick="startLogin(this)">
                        <span id="btnLabel">Continue with Zoho</span>
                        <span id="btnSpinner" style="display:none;"><span class="spinner" aria-hidden="true"></span></span>
                    </button>

                    {{-- Optional secondary: local fallback login/register --}}
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn secondary" role="button" aria-label="Register">
                            Create account
                        </a>
                    @endif
                @endauth
            </div>

            <div class="meta" aria-hidden="false">
                <span class="small">Need help?</span>
                <a href="mailto:support@example.com" class="small">Support</a>
                <span>&middot;</span>
                <a href="#" class="small">Privacy</a>
                <span>&middot;</span>
                <a href="#" class="small">Terms</a>
            </div>

            <div style="margin-top:14px; text-align:center;">
                <div class="small">Token status:
                    @if (auth()->check())
                        <strong style="color:#a6f0c3">Connected</strong>
                    @else
                        <strong style="color:#f6b1b1">Not connected</strong>
                    @endif
                </div>
            </div>

            <footer class="site-foot" aria-hidden="true">
                © {{ date('Y') }} {{ config('app.name', 'VeerIT') }}
            </footer>
        </main>
    </div>

    {{-- Minimal JS for spinner + safe redirect: uses route('login') if exists, otherwise fallback to '/zoho/auth' --}}
    <script>
        function startLogin(btn) {
            var loginRoute = null;
            @if (Route::has('login'))
                loginRoute = "{{ route('login') }}";
            @else
                loginRoute = "/zoho/auth";
            @endif

            // disable button, show spinner
            btn.setAttribute('disabled', 'disabled');
            document.getElementById('btnLabel').style.display = 'none';
            document.getElementById('btnSpinner').style.display = 'inline-block';

            // give tiny UX delay for spinner to show, then navigate
            setTimeout(function() {
                // use window.location to go to OAUTH redirect
                window.location.href = loginRoute;
            }, 350);
        }
    </script>
</body>

</html>
