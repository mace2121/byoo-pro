<script>
    window.landingPage = function () {
        return {
            mobileMenuOpen: false,
            navSolid: false,
            activeFaq: 0,
            init() {
                this.updateNavState();
                window.addEventListener("scroll", () => this.updateNavState(), { passive: true });
            },
            updateNavState() {
                this.navSolid = window.scrollY > 18;
            },
            faqClass(index) {
                return this.activeFaq === index
                    ? "border-[rgba(216,178,122,0.28)] bg-[rgba(216,178,122,0.08)]"
                    : "border-white/10 bg-white/[0.03]";
            }
        };
    };
</script>
