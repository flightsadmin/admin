<?php

namespace App\Livewire;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Cache;

class Settings extends Component
{
    use WithFileUploads;
    public $settings;

    public function mount()
    {
        $this->settings = Setting::pluck('value', 'key')->toArray();
    }

    public function updateSettings()
    {
        $validatedData = $this->validate([
            'settings.site_name' => ['required', 'string'],
            'settings.site_short_code' => ['required', 'string'],
            'settings.site_email' => ['required', 'email'],
            'settings.site_phone' => ['nullable', 'string'],
            'settings.footer_text' => ['nullable', 'string'],
            'settings.site_logo' => ['nullable'],
            'settings.site_theme' => ['nullable', 'string'],
            'settings.site_currency' => ['nullable', 'string'],
            'settings.date_time_format' => ['nullable', 'string'],
            'settings.date_format' => ['nullable', 'string'],
            'settings.time_format' => ['nullable', 'string'],
            'settings.week_start' => ['nullable', 'string'],
            'settings.site_description' => ['nullable', 'string'],
        ]);

        if (array_key_exists('site_logo', $this->settings)) {
            if (!is_string($this->settings['site_logo'])) {
                $validatedData['settings']['site_logo'] = $this->settings['site_logo']->storeAs('sites', 'default.png', 'public');
            }
        }

        foreach ($validatedData['settings'] as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value],
            );
        }
        $this->dispatch(
            'closeModal',
            icon: 'success',
            message: 'Settings updated successfully',
        );

        Cache::flush();
        return redirect(route('admin.settings'), true);
    }

    public function render()
    {
        return view('livewire.admin.settings.setting')->extends('components.layouts.admin');
    }
}
