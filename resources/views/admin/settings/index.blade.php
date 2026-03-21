<x-app-layout>
    <div class="h-full flex">
        @include('admin.partials.sidebar')

        <div class="flex-1 min-w-0 flex flex-col">
            @include('admin.partials.navbar')

            <main class="flex-1 overflow-y-auto bg-background">
                <div class="max-w-4xl mx-auto p-6 md:p-10 space-y-8">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight">Sistem Ayarları</h1>
                        <p class="mt-1 text-sm text-muted-foreground">Uygulamanın çalışması için gerekli temel ayarları yapılandırın.</p>
                    </div>

                    @if(session('success'))
                        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-green-900/20 dark:text-green-400">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Google Auth Ayarları -->
                    <div class="rounded-lg border border-border bg-card shadow-sm">
                        <div class="p-6 border-b border-border">
                            <h3 class="text-lg font-semibold flex items-center gap-2">
                                <i class="fab fa-google text-red-500"></i>
                                Google ile Giriş Ayarları
                            </h3>
                            <p class="text-sm text-muted-foreground mt-1">Google OAuth 2.0 kimlik bilgilerinizi buraya girerek Google hesabıyla girişleri yönetin. Bu veriler anında sistem yapılandırmanıza (.env) işlenecektir.</p>
                        </div>
                        <div class="p-6">
                            <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
                                @csrf

                                <div>
                                    <x-input-label for="google_client_id" value="GOOGLE_CLIENT_ID" />
                                    <x-text-input id="google_client_id" name="google_client_id" type="text" class="mt-1 block w-full" :value="env('GOOGLE_CLIENT_ID')" placeholder="Müşteri Kimliği" />
                                    <p class="mt-1 text-xs text-muted-foreground">Google Cloud Console üzerinden aldığınız İstemci Kimliği (Client ID)</p>
                                </div>

                                <div>
                                    <x-input-label for="google_client_secret" value="GOOGLE_CLIENT_SECRET" />
                                    <x-text-input id="google_client_secret" name="google_client_secret" type="password" class="mt-1 block w-full" :value="env('GOOGLE_CLIENT_SECRET')" placeholder="Gizli Anahtar" />
                                    <p class="mt-1 text-xs text-muted-foreground">Geliştirici konsolundaki İstemci Gizli Anahtarı (Client Secret)</p>
                                </div>

                                <div>
                                    <x-input-label for="google_redirect_uri" value="GOOGLE_REDIRECT_URI" />
                                    <x-text-input id="google_redirect_uri" name="google_redirect_uri" type="text" class="mt-1 block w-full" :value="env('GOOGLE_REDIRECT_URI', '${APP_URL}/auth/google/callback')" placeholder="${APP_URL}/auth/google/callback" />
                                    <p class="mt-1 text-xs text-muted-foreground">Genellikle <code>${APP_URL}/auth/google/callback</code> olarak girilir.</p>
                                </div>

                                <div class="flex items-center justify-end">
                                    <x-primary-button>
                                        {{ __('Ayarları Kaydet') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
