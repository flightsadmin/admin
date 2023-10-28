<?php

namespace App\Livewire;

use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Livewire\WithFileUploads;

class Settings extends Component
{
    use WithFileUploads;
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
        try {
            $setting = Setting::first();

            if (array_key_exists('site_logo', $this->state)) {
                if (!is_string($this->state['site_logo'])) {
                    $this->state['site_logo'] = $this->state['site_logo']->storeAs('sites', 'default.png', 'public');
                }
            }

            if ($setting) {
                $setting->update($this->state);
            } else {
                Setting::create($this->state);
            }

            Cache::forget('setting');
        } catch (\Exception $ex) {
            echo '<div class="alert alert-danger">'.$ex->getMessage().'</div>';
        }
        return redirect(route('admin.settings'));
    }

    public function alert() {
        $this->dispatch(
            'closeModal',
            icon: "success",
            message: 'Setting Updated Successfully.',
        );
    }
    public function render()
    {
        return view('livewire.admin.settings.setting')->extends('components.layouts.admin');
    }
}