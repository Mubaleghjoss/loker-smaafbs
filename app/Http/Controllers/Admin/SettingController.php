<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSettingsRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        return view('admin.settings.edit', [
            'admin_whatsapp' => Setting::getValue('admin_whatsapp', '+6283818393029'),
            'mail_confirm_enabled' => Setting::getValue('mail_confirm_enabled', '0') === '1',
            'brand_color' => Setting::getValue('brand_color', '#6366f1'),
            'brand_color_secondary' => Setting::getValue('brand_color_secondary', '#8b5cf6'),
            'footer_text' => Setting::getValue('footer_text', '© ' . date('Y') . ' SMA AFBS — Sistem Rekrutmen'),
            'site_name' => Setting::getValue('site_name', 'Rekrutmen Guru SMA AFBS'),
            'site_description' => Setting::getValue('site_description', 'Sistem rekrutmen guru dan staf SMA Al Furqon Boarding School'),
            'navbar_title' => Setting::getValue('navbar_title', 'Rekrutmen Guru'),
            'navbar_subtitle' => Setting::getValue('navbar_subtitle', 'SMA AFBS'),
            'hero_title' => Setting::getValue('hero_title', 'Rekrutmen Guru\nSMA AFBS'),
            'hero_description' => Setting::getValue('hero_description', 'Bergabunglah bersama kami membangun pendidikan berkualitas. Daftar sekarang dan jadilah bagian dari keluarga SMA Al Furqon Boarding School.'),
            'powered_by' => Setting::getValue('powered_by', 'Powered by Laravel'),
            'current_favicon' => Setting::getValue('favicon_path'),
            'current_og_image' => Setting::getValue('og_image_path'),
        ]);
    }

    public function update(UpdateSettingsRequest $request)
    {
        $data = $request->validated();

        Setting::putValue('admin_whatsapp', $data['admin_whatsapp']);
        Setting::putValue('mail_confirm_enabled', !empty($data['mail_confirm_enabled']) ? '1' : '0');

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    /**
     * Update branding settings (colors, footer, site name, favicon, OG image).
     */
    public function updateBranding(Request $request)
    {
        $request->validate([
            'brand_color' => ['required', 'string', 'max:20'],
            'brand_color_secondary' => ['required', 'string', 'max:20'],
            'footer_text' => ['nullable', 'string', 'max:500'],
            'site_name' => ['nullable', 'string', 'max:200'],
            'site_description' => ['nullable', 'string', 'max:500'],
            'navbar_title' => ['nullable', 'string', 'max:100'],
            'navbar_subtitle' => ['nullable', 'string', 'max:100'],
            'hero_title' => ['nullable', 'string', 'max:200'],
            'hero_description' => ['nullable', 'string', 'max:1000'],
            'powered_by' => ['nullable', 'string', 'max:200'],
            'favicon' => ['nullable', 'image', 'mimes:png,jpg,jpeg,ico,svg', 'max:2048'],
            'og_image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:5120'],
        ], [
            'favicon.image' => 'Favicon harus berupa file gambar.',
            'favicon.mimes' => 'Favicon harus format PNG, JPG, ICO, atau SVG.',
            'favicon.max' => 'Favicon maksimal 2MB.',
            'og_image.image' => 'OG Image harus berupa file gambar.',
            'og_image.mimes' => 'OG Image harus format PNG atau JPG.',
            'og_image.max' => 'OG Image maksimal 5MB.',
        ]);

        Setting::putValue('brand_color', $request->input('brand_color'));
        Setting::putValue('brand_color_secondary', $request->input('brand_color_secondary'));
        Setting::putValue('footer_text', $request->input('footer_text'));
        Setting::putValue('site_name', $request->input('site_name'));
        Setting::putValue('site_description', $request->input('site_description'));
        Setting::putValue('navbar_title', $request->input('navbar_title'));
        Setting::putValue('navbar_subtitle', $request->input('navbar_subtitle'));
        Setting::putValue('hero_title', $request->input('hero_title'));
        Setting::putValue('hero_description', $request->input('hero_description'));
        Setting::putValue('powered_by', $request->input('powered_by'));

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $file = $request->file('favicon');
            $filename = 'favicon.' . ($file->extension() ?: 'png');
            $file->move(public_path(), $filename);
            Setting::putValue('favicon_path', $filename);
        }

        // Handle OG image upload
        if ($request->hasFile('og_image')) {
            $file = $request->file('og_image');
            $filename = 'og-image.' . ($file->extension() ?: 'png');
            $file->move(public_path(), $filename);
            Setting::putValue('og_image_path', $filename);
        }

        return back()->with('success', 'Pengaturan tampilan berhasil disimpan.');
    }
}
