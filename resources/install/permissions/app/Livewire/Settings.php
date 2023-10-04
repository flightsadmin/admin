<?php

namespace App\Livewire;

use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class Settings extends Component
{
    public $state = [];

    public function mount()
    {
        $setting = Setting::first();

        if ($setting) {
            $this->state = $setting->toArray();
        }
    }

    public function updateSetting()
    {
        $setting = Setting::first();

        if ($setting) {
            $setting->update($this->state);
        } else {
            Setting::create($this->state);
        }

        Cache::forget('setting');
        return redirect(route('admin.settings'));
    }

    public function render()
    {
        return view('livewire.admin.settings.setting')->extends('components.layouts.admin');
    }
}