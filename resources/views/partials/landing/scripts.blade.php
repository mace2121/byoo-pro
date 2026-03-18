<script>
    window.landingExperience = function () {
        return {
            mobileMenuOpen: false,
            navSolid: false,
            activeScene: "hero",
            activeFaq: 0,
            activeTestimonial: 0,
            countsStarted: false,
            blurLevel: 22,
            selectedThemeKey: "aqua",
            selectedFontKey: "poppins",
            composerKind: "link",
            blockSeed: 4,
            counts: { creators: 0, links: 0, sales: 0 },
            countTargets: { creators: 512, links: 12840, sales: 3720 },
            themes: [
                { key: "aqua", name: "Aqua Neon", accent: "#00ffcc", secondary: "#6c5ce7", surface: "#081120", panel: "#10213a", text: "#ecfeff", muted: "#94a3b8", glow: "rgba(0,255,204,0.22)" },
                { key: "sunset", name: "Sunset Pop", accent: "#fb7185", secondary: "#f59e0b", surface: "#1a1020", panel: "#34152e", text: "#fff7ed", muted: "#fdba74", glow: "rgba(251,113,133,0.24)" },
                { key: "electric", name: "Electric Mint", accent: "#7c3aed", secondary: "#22d3ee", surface: "#090f1f", panel: "#181b39", text: "#eef2ff", muted: "#c4b5fd", glow: "rgba(34,211,238,0.24)" }
            ],
            fonts: [
                { key: "poppins", label: "Poppins", stack: "'Poppins', sans-serif" },
                { key: "inter", label: "Inter", stack: "'Inter', sans-serif" }
            ],
            composerKinds: [
                { key: "link", label: "Link Block", icon: "fa-link" },
                { key: "product", label: "Product Block", icon: "fa-bag-shopping" },
                { key: "whatsapp", label: "WhatsApp CTA", icon: "fa-whatsapp" },
                { key: "social", label: "Social Icons", icon: "fa-hashtag" }
            ],
            blockTemplates: {
                link: [
                    { title: "Portfolyo", subtitle: "Dribbble ve Behance secimleri", icon: "fa-briefcase", kind: "link" },
                    { title: "Yeni Kampanya", subtitle: "Instagram reels yonlendirmesi", icon: "fa-bolt", kind: "link" },
                    { title: "Rezervasyon Formu", subtitle: "Hizli yonlendirme akisi", icon: "fa-calendar-check", kind: "link" }
                ],
                product: [
                    { title: "Mini Urun Karti", subtitle: "799 TL • WhatsApp siparis", icon: "fa-bag-shopping", kind: "product" },
                    { title: "Dijital Rehber", subtitle: "PDF satisi icin one cikan blok", icon: "fa-file-arrow-down", kind: "product" }
                ],
                whatsapp: [
                    { title: "Siparis Al", subtitle: "Tek tikla WhatsApp sohbeti baslat", icon: "fa-whatsapp", kind: "whatsapp" }
                ],
                social: [
                    { title: "Sosyal Aglar", subtitle: "Instagram, TikTok, X ve YouTube", icon: "fa-share-nodes", kind: "social" }
                ]
            },
            builderBlocks: [
                { id: 1, title: "Portfolyo", subtitle: "Dribbble ve Behance secimleri", icon: "fa-briefcase", kind: "link", enabled: true },
                { id: 2, title: "Premium Paket", subtitle: "799 TL • WhatsApp ile siparis", icon: "fa-bag-shopping", kind: "product", enabled: true },
                { id: 3, title: "WhatsApp Destek", subtitle: "Sorular icin direkt mesaj", icon: "fa-whatsapp", kind: "whatsapp", enabled: true },
                { id: 4, title: "Sosyal Kanallar", subtitle: "Instagram, TikTok ve YouTube", icon: "fa-share-nodes", kind: "social", enabled: true }
            ],
            products: [
                { name: "Premium Theme Pack", price: "799 TL", subtitle: "Tema, blok ve CTA seti" },
                { name: "Creator Kit", price: "1.290 TL", subtitle: "Link, urun ve analiz paketi" }
            ],
            testimonials: [
                { name: "Derya Celik", role: "Creator", quote: "Landing sayfasini gordukten sonra urunun nasil calistigini saniyeler icinde anladim. Demo akisi signup oranini ciddi arttirdi." },
                { name: "Mert Koc", role: "Kucuk isletme sahibi", quote: "WhatsApp siparis bloklari ve canli tema onizlemesi sayesinde byoo.pro'yu ekibe anlatmak cok kolaylasti." },
                { name: "Buse Arslan", role: "Ajans kurucusu", quote: "Tek sayfada urunu gostermek yerine deneyimletmek en guclu fark oldu. Builder bolumu landing'in kalbi gibi calisiyor." }
            ],
            init() {
                this.setupRevealObserver();
                this.setupSceneObserver();
                this.setupStatsObserver();
                this.startTestimonialRotation();
                this.updateNavState();
                window.addEventListener("scroll", () => this.updateNavState(), { passive: true });
            },
            updateNavState() {
                this.navSolid = window.scrollY > 18;
            },
            setupRevealObserver() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add("is-visible");
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.18 });
                document.querySelectorAll("[data-reveal]").forEach((element) => observer.observe(element));
            },
            setupSceneObserver() {
                const observer = new IntersectionObserver((entries) => {
                    const visible = entries.filter((entry) => entry.isIntersecting).sort((left, right) => right.intersectionRatio - left.intersectionRatio);
                    if (visible.length > 0) {
                        this.activeScene = visible[0].target.dataset.scene;
                    }
                }, { threshold: [0.25, 0.5, 0.75] });
                document.querySelectorAll("[data-scene]").forEach((element) => observer.observe(element));
            },
            setupStatsObserver() {
                const section = document.querySelector("[data-stats]");
                if (!section) {
                    return;
                }
                const observer = new IntersectionObserver((entries) => {
                    if (entries.some((entry) => entry.isIntersecting)) {
                        this.startCounts();
                        observer.disconnect();
                    }
                }, { threshold: 0.3 });
                observer.observe(section);
            },
            startCounts() {
                if (this.countsStarted) {
                    return;
                }
                this.countsStarted = true;
                const startedAt = performance.now();
                const duration = 1400;
                const animate = (now) => {
                    const progress = Math.min((now - startedAt) / duration, 1);
                    const eased = 1 - Math.pow(1 - progress, 3);
                    Object.keys(this.countTargets).forEach((key) => {
                        this.counts[key] = Math.round(this.countTargets[key] * eased);
                    });
                    if (progress < 1) {
                        requestAnimationFrame(animate);
                    }
                };
                requestAnimationFrame(animate);
            },
            startTestimonialRotation() {
                if (this.testimonials.length < 2) {
                    return;
                }
                window.setInterval(() => {
                    this.activeTestimonial = (this.activeTestimonial + 1) % this.testimonials.length;
                }, 4800);
            },
            currentTheme() {
                return this.themes.find((theme) => theme.key === this.selectedThemeKey) ?? this.themes[0];
            },
            currentFont() {
                return this.fonts.find((font) => font.key === this.selectedFontKey) ?? this.fonts[0];
            },
            previewShellStyle() {
                const theme = this.currentTheme();
                return [
                    "background:",
                    "radial-gradient(circle at top, " + theme.glow + " 0%, transparent 38%),",
                    "linear-gradient(180deg, " + theme.panel + " 0%, " + theme.surface + " 100%)",
                    "; color: " + theme.text,
                    "; box-shadow: inset 0 1px 0 rgba(255,255,255,0.04)",
                    "; font-family: " + this.currentFont().stack,
                    "; filter: saturate(1.03)"
                ].join("");
            },
            previewTitle() {
                if (this.activeScene === "products") return "Urun vitrini";
                if (this.activeScene === "customize") return "Canli tema editoru";
                if (this.activeScene === "proof") return "Guven ve donusum";
                if (this.activeScene === "cta") return "Yayina hazir sayfa";
                return "byoo.pro demo";
            },
            previewBlocks(limit = null) {
                const blocks = this.builderBlocks.filter((block) => block.enabled);
                return limit === null ? blocks : blocks.slice(0, limit);
            },
            addComposerBlock() {
                const options = this.blockTemplates[this.composerKind] ?? this.blockTemplates.link;
                const template = options[Math.floor(Math.random() * options.length)];
                this.blockSeed += 1;
                this.builderBlocks = [{
                    id: this.blockSeed,
                    title: template.title,
                    subtitle: template.subtitle,
                    icon: template.icon,
                    kind: template.kind,
                    enabled: true
                }, ...this.builderBlocks].slice(0, 6);
                this.activeScene = "builder";
            },
            toggleBlock(id) {
                this.builderBlocks = this.builderBlocks.map((block) => block.id !== id ? block : { ...block, enabled: !block.enabled });
            },
            removeBlock(id) {
                if (this.builderBlocks.length <= 1) {
                    return;
                }
                this.builderBlocks = this.builderBlocks.filter((block) => block.id !== id);
            },
            blockKindLabel(kind) {
                return { link: "Link", product: "Urun", whatsapp: "WhatsApp", social: "Sosyal" }[kind] ?? "Blok";
            },
            blockTone(kind) {
                if (kind === "product") return "background: rgba(251,191,36,0.12); color: #fbbf24;";
                if (kind === "whatsapp") return "background: rgba(34,197,94,0.12); color: #4ade80;";
                if (kind === "social") return "background: rgba(34,211,238,0.12); color: #67e8f9;";
                return "background: rgba(0,255,204,0.12); color: #5eead4;";
            },
            composerButtonClass(kind) {
                return this.composerKind === kind
                    ? "border-[#00ffcc]/40 bg-[#00ffcc]/10 text-white shadow-[0_0_0_1px_rgba(0,255,204,0.18)]"
                    : "border-white/10 bg-white/5 text-slate-300 hover:border-white/20 hover:text-white";
            },
            themeButtonClass(key) {
                return this.selectedThemeKey === key
                    ? "border-white/25 bg-white/10 text-white"
                    : "border-white/10 bg-white/5 text-slate-300 hover:border-white/20 hover:text-white";
            },
            fontButtonClass(key) {
                return this.selectedFontKey === key
                    ? "border-white/25 bg-white/10 text-white"
                    : "border-white/10 bg-white/5 text-slate-300 hover:border-white/20 hover:text-white";
            },
            faqButtonClass(index) {
                return this.activeFaq === index ? "border-white/20 bg-white/[0.04]" : "border-white/10 bg-white/[0.03]";
            },
            navLinkClass(scene) {
                return this.activeScene === scene ? "text-white" : "text-slate-400 hover:text-white";
            },
            formattedCount(key) {
                return new Intl.NumberFormat("tr-TR").format(this.counts[key] ?? 0);
            }
        };
    };
</script>
