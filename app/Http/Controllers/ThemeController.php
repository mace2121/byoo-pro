<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Theme;
use Illuminate\Support\Str;

class ThemeController extends Controller
{
    public function marketplace()
    {
        $themes = Theme::where('is_active', true)
            ->where('is_approved', true)
            ->with('creator')
            ->latest()
            ->get();

        return view('marketplace.index', compact('themes'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user->canCustomizeTheme()) {
            return back()->with('error', 'Tema oluşturma özelliği sadece Pro pakette mevcuttur.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'is_premium' => 'boolean',
        ]);

        $profile = $user->profile;
        if (!$profile) {
            return back()->with('error', 'Profil bulunamadı.');
        }

        $theme = Theme::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(5),
            'user_id' => $user->id,
            'is_premium' => $request->boolean('is_premium'),
            'is_active' => true,
            'is_approved' => false, // Needs admin approval
            'config_json' => $profile->design_settings ?? [],
        ]);

        return back()->with('success', 'Tema oluşturuldu ve onaya gönderildi.');
    }

    public function apply(Theme $theme)
    {
        $user = auth()->user();
        
        if ($theme->is_premium && !$user->isPro()) {
            return back()->with('error', 'Bu tema sadece Pro üyeler içindir.');
        }

        $profile = $user->profile;
        $profile->update([
            'theme_id' => $theme->id,
            // When applying a theme, we can choose to reset custom design or keep it as overrides
            // For simplicity, we'll just set the theme_id and let DesignEditor handle merging
        ]);

        return back()->with('success', 'Tema başarıyla uygulandı.');
    }
}
