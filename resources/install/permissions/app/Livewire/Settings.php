<?php

namespace App\Livewire;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

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
        $this->dispatch('updated', ['message' => 'Settings updated successfully!']);
    }

    public function render()
    {
        return view('livewire.admin.settings.setting')->extends('components.layouts.admin');
    }
}