<style>
    [x-cloak] {
        display: none !important;
    }

    :root {
        --landing-bg: #050505;
        --landing-panel: rgba(255, 255, 255, 0.05);
        --landing-panel-strong: rgba(255, 255, 255, 0.08);
        --landing-border: rgba(255, 255, 255, 0.12);
        --landing-muted: #a1a1aa;
        --landing-text: #f5f2eb;
        --landing-accent: #d8b27a;
        --landing-accent-soft: rgba(216, 178, 122, 0.16);
        --landing-accent-strong: #f0d4a8;
        --landing-success: #8bd3c7;
    }

    .landing-body {
        background:
            radial-gradient(circle at top, rgba(216, 178, 122, 0.08), transparent 28%),
            radial-gradient(circle at 80% 20%, rgba(139, 211, 199, 0.08), transparent 22%),
            linear-gradient(180deg, #060606 0%, #090909 36%, #040404 100%);
        color: var(--landing-text);
        font-family: "Inter", sans-serif;
    }

    .landing-mesh {
        position: fixed;
        inset: 0;
        pointer-events: none;
        z-index: -30;
        background-image:
            linear-gradient(rgba(255, 255, 255, 0.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.04) 1px, transparent 1px);
        background-size: 48px 48px;
        mask-image: radial-gradient(circle at center, rgba(0, 0, 0, 0.82), transparent 78%);
        opacity: 0.25;
    }

    .landing-glow {
        position: absolute;
        z-index: -20;
        height: 26rem;
        width: 26rem;
        border-radius: 9999px;
        filter: blur(90px);
        opacity: 0.34;
        pointer-events: none;
    }

    .landing-glow-left {
        left: -8rem;
        top: 5rem;
        background: rgba(216, 178, 122, 0.18);
    }

    .landing-glow-right {
        right: -10rem;
        top: 18rem;
        background: rgba(139, 211, 199, 0.16);
    }

    .landing-heading {
        font-family: "Manrope", sans-serif;
        letter-spacing: -0.04em;
    }

    .premium-panel {
        background:
            linear-gradient(180deg, rgba(255, 255, 255, 0.07), rgba(255, 255, 255, 0.03));
        border: 1px solid var(--landing-border);
        box-shadow:
            0 24px 80px rgba(0, 0, 0, 0.42),
            inset 0 1px 0 rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(18px);
    }

    .premium-panel-soft {
        background:
            linear-gradient(180deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.02));
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(16px);
    }

    .premium-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.625rem;
        padding: 0.55rem 0.95rem;
        border-radius: 9999px;
        border: 1px solid rgba(216, 178, 122, 0.28);
        background: rgba(216, 178, 122, 0.1);
        color: var(--landing-accent-strong);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.16em;
        text-transform: uppercase;
    }

    .premium-button {
        background: linear-gradient(135deg, #f0d4a8 0%, #d8b27a 100%);
        color: #0c0c0c;
        box-shadow: 0 18px 38px rgba(216, 178, 122, 0.24);
    }

    .premium-button:hover {
        filter: brightness(1.04);
        transform: translateY(-1px);
    }

    .premium-button-ghost {
        border: 1px solid rgba(255, 255, 255, 0.14);
        background: rgba(255, 255, 255, 0.04);
        color: #f8f5ef;
    }

    .premium-button-ghost:hover {
        background: rgba(255, 255, 255, 0.07);
    }

    .premium-stat {
        border-radius: 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(255, 255, 255, 0.03);
    }

    .premium-list-line {
        height: 1px;
        width: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.12), transparent);
    }

    .phone-frame {
        position: relative;
        overflow: hidden;
        border-radius: 2.6rem;
        border: 1px solid rgba(255, 255, 255, 0.14);
        background: linear-gradient(180deg, #141414 0%, #090909 100%);
        padding: 0.9rem;
        box-shadow:
            0 28px 65px rgba(0, 0, 0, 0.52),
            inset 0 1px 0 rgba(255, 255, 255, 0.04);
    }

    .phone-frame::before {
        content: "";
        position: absolute;
        left: 50%;
        top: 0.7rem;
        height: 1.6rem;
        width: 7.4rem;
        transform: translateX(-50%);
        border-radius: 9999px;
        background: #050505;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .phone-screen {
        min-height: 36rem;
        border-radius: 2rem;
        background:
            radial-gradient(circle at top, rgba(216, 178, 122, 0.16), transparent 24%),
            linear-gradient(180deg, #181818 0%, #0f0f10 52%, #090909 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 2.5rem 1rem 1rem;
    }

    .accent-line {
        background: linear-gradient(90deg, transparent, rgba(216, 178, 122, 0.7), transparent);
    }

    .reveal-up {
        opacity: 0;
        transform: translateY(20px);
        animation: reveal-up 0.7s ease forwards;
    }

    .reveal-up-delay {
        opacity: 0;
        transform: translateY(20px);
        animation: reveal-up 0.7s ease forwards 0.12s;
    }

    .reveal-up-delay-2 {
        opacity: 0;
        transform: translateY(20px);
        animation: reveal-up 0.7s ease forwards 0.22s;
    }

    @keyframes reveal-up {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .reveal-up,
        .reveal-up-delay,
        .reveal-up-delay-2 {
            opacity: 1;
            transform: none;
            animation: none;
        }

        html {
            scroll-behavior: auto;
        }
    }
</style>
