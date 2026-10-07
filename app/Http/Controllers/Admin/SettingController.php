<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminMenu;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display the settings management panel.
     */
    public function index(Request $request): View
    {
        $allSettings = Setting::allCached();
        $rawSettings = Setting::query()->orderBy('group')->orderBy('key')->paginate(25);

        return view('admin.settings', [
            'adminMenu' => AdminMenu::sidebarFor($request->user()),
            'settings' => $allSettings,
            'rawSettings' => $rawSettings,
        ]);
    }

    /**
     * Update settings grouped across General, Contact, Social, Footer, and SEO.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // General
            'general.site_name' => ['required', 'string', 'max:120'],
            'general.tagline' => ['nullable', 'string', 'max:255'],
            'general.site_url' => ['nullable', 'string', 'max:255'],
            'general.logo' => ['nullable', 'string', 'max:255'],
            'logo_upload' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:4096'],

            // Contact
            'contact.email' => ['required', 'email', 'max:120'],
            'contact.support_email' => ['nullable', 'email', 'max:120'],
            'contact.phone' => ['required', 'string', 'max:50'],
            'contact.whatsapp' => ['nullable', 'string', 'max:50'],
            'contact.address' => ['required', 'string', 'max:500'],
            'contact.working_hours' => ['nullable', 'string', 'max:150'],

            // Social
            'social.facebook' => ['nullable', 'url', 'max:255'],
            'social.instagram' => ['nullable', 'url', 'max:255'],
            'social.twitter' => ['nullable', 'url', 'max:255'],
            'social.youtube' => ['nullable', 'url', 'max:255'],
            'social.whatsapp' => ['nullable', 'string', 'max:255'],

            // Footer
            'footer.copyright' => ['required', 'string', 'max:255'],
            'footer.about_text_en' => ['nullable', 'string', 'max:1000'],
            'footer.about_text_ar' => ['nullable', 'string', 'max:1000'],
            'footer.about_text_ru' => ['nullable', 'string', 'max:1000'],

            // SEO
            'seo.meta_title' => ['required', 'string', 'max:255'],
            'seo.meta_description' => ['nullable', 'string', 'max:500'],
            'seo.meta_keywords' => ['nullable', 'string', 'max:500'],
        ]);

        // Handle logo file upload if provided
        if ($request->hasFile('logo_upload')) {
            $file = $request->file('logo_upload');
            $filename = 'logo_custom_'.time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/images'), $filename);
            Setting::set('general.logo', '/assets/images/'.$filename);
        } elseif (! empty($validated['general']['logo'])) {
            Setting::set('general.logo', $validated['general']['logo']);
        }

        // Save General
        Setting::set('general.site_name', $validated['general']['site_name']);
        Setting::set('general.tagline', $validated['general']['tagline'] ?? '');
        Setting::set('general.site_url', $validated['general']['site_url'] ?? 'https://dubaitourbook.com');

        // Save Contact
        Setting::set('contact.email', $validated['contact']['email']);
        Setting::set('contact.support_email', $validated['contact']['support_email'] ?? '');
        Setting::set('contact.phone', $validated['contact']['phone']);
        Setting::set('contact.whatsapp', $validated['contact']['whatsapp'] ?? '');
        Setting::set('contact.address', $validated['contact']['address']);
        Setting::set('contact.working_hours', $validated['contact']['working_hours'] ?? '24/7 VIP Concierge & Booking Desk');

        // Save Social
        Setting::set('social.facebook', $validated['social']['facebook'] ?? '');
        Setting::set('social.instagram', $validated['social']['instagram'] ?? '');
        Setting::set('social.twitter', $validated['social']['twitter'] ?? '');
        Setting::set('social.youtube', $validated['social']['youtube'] ?? '');
        Setting::set('social.whatsapp', $validated['social']['whatsapp'] ?? '');

        // Save Footer
        Setting::set('footer.copyright', $validated['footer']['copyright']);
        $aboutText = [
            'en' => $validated['footer']['about_text_en'] ?? '',
            'ar' => $validated['footer']['about_text_ar'] ?? '',
            'ru' => $validated['footer']['about_text_ru'] ?? '',
        ];
        Setting::set('footer.about_text', $aboutText);

        // Save SEO
        Setting::set('seo.meta_title', $validated['seo']['meta_title']);
        Setting::set('seo.meta_description', $validated['seo']['meta_description'] ?? '');
        Setting::set('seo.meta_keywords', $validated['seo']['meta_keywords'] ?? '');

        // Clear cache
        Cache::forget('site_settings');

        return redirect()->route('admin.settings.index')->with('success', 'Website settings, branding, and contact details updated successfully!');
    }

    /**
     * Store an individual raw key-value setting.
     */
    public function storeRaw(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'group' => ['required', 'string', 'max:60', 'alpha_dash'],
            'key' => ['required', 'string', 'max:60', 'alpha_dash'],
            'value' => ['required', 'string'],
        ]);

        $val = $validated['value'];
        $decoded = json_decode($val, true);
        if (json_last_error() === JSON_ERROR_NONE && (is_array($decoded) || is_object($decoded))) {
            $val = $decoded;
        }

        Setting::updateOrCreate(
            ['group' => $validated['group'], 'key' => $validated['key']],
            ['value' => $val]
        );

        Cache::forget('site_settings');

        return redirect()->route('admin.settings.index')->with('success', "Setting {$validated['group']}.{$validated['key']} saved successfully.");
    }

    /**
     * Remove an individual raw setting.
     */
    public function destroyRaw(Setting $setting): RedirectResponse
    {
        $name = "{$setting->group}.{$setting->key}";
        $setting->delete();
        Cache::forget('site_settings');

        return redirect()->route('admin.settings.index')->with('success', "Setting '{$name}' deleted successfully.");
    }
}
