<style>
    [x-cloak] {
        display: none !important;
    }

    .landing-body {
        background: #030712;
        color: #e2e8f0;
        font-family: "Inter", sans-serif;
    }

    .landing-grid-overlay {
        position: fixed;
        inset: 0;
        pointer-events: none;
        z-index: -30;
        background-image:
            linear-gradient(rgba(148, 163, 184, 0.06) 1px, transparent 1px),
            linear-gradient(90deg, rgba(148, 163, 184, 0.06) 1px, transparent 1px);
        background-size: 48px 48px;
        mask-image: radial-gradient(circle at center, rgba(0, 0, 0, 0.9), transparent 75%);
        opacity: 0.35;
    }

    .landing-noise {
        position: fixed;
        inset: 0;
        pointer-events: none;
        z-index: -20;
        background-image: radial-gradient(rgba(255, 255, 255, 0.04) 0.8px, transparent 0.8px);
        background-size: 14px 14px;
        opacity: 0.12;
    }

    .landing-heading {
        font-family: "Poppins", sans-serif;
        letter-spacing: -0.03em;
    }

    .glass-panel {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.84), rgba(15, 23, 42, 0.62));
        border: 1px solid rgba(148, 163, 184, 0.14);
        box-shadow: 0 24px 80px rgba(2, 8, 23, 0.38);
        backdrop-filter: blur(18px);
    }

    .glass-panel-soft {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.68), rgba(15, 23, 42, 0.44));
        border: 1px solid rgba(148, 163, 184, 0.12);
        backdrop-filter: blur(14px);
    }

    .section-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.625rem;
        padding: 0.5rem 0.875rem;
        border-radius: 9999px;
        border: 1px solid rgba(0, 255, 204, 0.18);
        background: rgba(7, 18, 32, 0.72);
        color: #7dd3fc;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
    }

    .glow-button {
        box-shadow:
            0 0 0 1px rgba(255, 255, 255, 0.03),
            0 16px 40px rgba(0, 255, 204, 0.22);
    }

    .ghost-button {
        box-shadow: inset 0 0 0 1px rgba(148, 163, 184, 0.18);
    }

    .reveal {
        opacity: 0;
        transform: translateY(28px);
        transition:
            opacity 0.7s ease,
            transform 0.7s ease;
    }

    .reveal.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .phone-shell {
        position: relative;
        overflow: hidden;
        border-radius: 2.5rem;
        border: 1px solid rgba(255, 255, 255, 0.14);
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.94), rgba(2, 6, 23, 0.94));
        padding: 0.875rem;
        box-shadow:
            0 24px 60px rgba(2, 6, 23, 0.55),
            0 0 0 1px rgba(255, 255, 255, 0.03);
    }

    .phone-shell::before {
        content: "";
        position: absolute;
        left: 50%;
        top: 0.65rem;
        height: 1.65rem;
        width: 7.25rem;
        transform: translateX(-50%);
        border-radius: 9999px;
        background: rgba(2, 6, 23, 0.92);
        border: 1px solid rgba(255, 255, 255, 0.04);
        z-index: 2;
    }

    .phone-screen {
        min-height: 38rem;
        border-radius: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 2.5rem 1rem 1rem;
        color: #f8fafc;
        transition:
            background 0.35s ease,
            box-shadow 0.35s ease,
            filter 0.35s ease;
    }

    .phone-card {
        border-radius: 1.25rem;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(255, 255, 255, 0.07);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.04);
    }

    .stat-card {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.55));
        border: 1px solid rgba(148, 163, 184, 0.12);
        box-shadow: 0 18px 45px rgba(2, 8, 23, 0.26);
    }

    .picker-dot {
        box-shadow:
            0 0 0 2px rgba(15, 23, 42, 0.9),
            0 0 0 3px rgba(255, 255, 255, 0.1);
    }

    .range-input {
        -webkit-appearance: none;
        appearance: none;
        height: 0.45rem;
        width: 100%;
        border-radius: 9999px;
        background: rgba(148, 163, 184, 0.18);
        outline: none;
    }

    .range-input::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 1.15rem;
        height: 1.15rem;
        border-radius: 9999px;
        background: #00ffcc;
        box-shadow: 0 0 0 4px rgba(0, 255, 204, 0.16);
        cursor: pointer;
    }

    .range-input::-moz-range-thumb {
        width: 1.15rem;
        height: 1.15rem;
        border: 0;
        border-radius: 9999px;
        background: #00ffcc;
        box-shadow: 0 0 0 4px rgba(0, 255, 204, 0.16);
        cursor: pointer;
    }

    .pulse-ring {
        animation: landing-pulse 2.8s ease-in-out infinite;
    }

    @keyframes landing-pulse {
        0%,
        100% {
            box-shadow: 0 0 0 0 rgba(0, 255, 204, 0.12);
        }
        50% {
            box-shadow: 0 0 0 12px rgba(0, 255, 204, 0);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .reveal,
        .pulse-ring {
            animation: none !important;
            transition: none !important;
            transform: none !important;
            opacity: 1 !important;
        }

        html {
            scroll-behavior: auto;
        }
    }
</style>
