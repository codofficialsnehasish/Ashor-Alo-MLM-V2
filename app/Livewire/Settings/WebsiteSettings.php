<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\WebsiteSetting;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class WebsiteSettings extends Component
{
    use WithFileUploads;

    public $site_name;
    public $site_description;
    public $contact_email;
    public $contact_number;
    public $contact_address;
    public $maintenance_mode = false;
    public $maintenance_message;
    public $header_scripts;
    public $footer_scripts;
    public $seo_meta_description;
    public $seo_meta_keywords;
    public $terms_and_conditions;
    public $privacy_policy;
    public $logo;
    public $favicon;
    public $existingLogo;
    public $existingFavicon;

    protected $rules = [
        'site_name' => 'required|string|max:255',
        'site_description' => 'nullable|string',
        'contact_email' => 'nullable|email',
        'contact_number' => 'nullable|string|max:20',
        'contact_address' => 'nullable|string',
        'maintenance_mode' => 'boolean',
        'maintenance_message' => 'nullable|string',
        'header_scripts' => 'nullable|string',
        'footer_scripts' => 'nullable|string',
        'seo_meta_description' => 'nullable|string',
        'seo_meta_keywords' => 'nullable|string',
        'terms_and_conditions' => 'nullable|string',
        'privacy_policy' => 'nullable|string',
        'logo' => 'nullable|image|max:2048',
        'favicon' => 'nullable|image|max:1024',
    ];

    public function mount()
    {
        $settings = WebsiteSetting::first();

        if ($settings) {
            $this->fill([
                'site_name' => $settings->site_name,
                'site_description' => $settings->site_description,
                'contact_email' => $settings->contact_email,
                'contact_number' => $settings->contact_number,
                'contact_address' => $settings->contact_address,
                'maintenance_mode' => $settings->maintenance_mode,
                'maintenance_message' => $settings->maintenance_message,
                'header_scripts' => $settings->header_scripts,
                'footer_scripts' => $settings->footer_scripts,
                'seo_meta_description' => $settings->seo_meta_description,
                'seo_meta_keywords' => $settings->seo_meta_keywords,
                'terms_and_conditions' => $settings->terms_and_conditions,
                'privacy_policy' => $settings->privacy_policy,
                'existingLogo' => $settings->getFirstMediaUrl('site-logo'),
                'existingFavicon' => $settings->getFirstMediaUrl('site-favicon'),
            ]);
        }
    }

    public function saveSettings()
    {
        $this->validate();

        $settings = WebsiteSetting::firstOrNew([]);

        // Handle logo upload
        if ($this->logo) {
            $settings->clearMediaCollection('site-logo');
            $settings->addMedia($this->logo)->toMediaCollection('site-logo');
        }

        // Handle favicon upload
        if ($this->favicon) {
            $settings->clearMediaCollection('site-favicon');
            $settings->addMedia($this->favicon)->toMediaCollection('site-favicon');
        }

        $settings->fill([
            'site_name' => $this->site_name,
            'site_description' => $this->site_description,
            'contact_email' => $this->contact_email,
            'contact_number' => $this->contact_number,
            'contact_address' => $this->contact_address,
            'maintenance_mode' => $this->maintenance_mode,
            'maintenance_message' => $this->maintenance_message,
            'header_scripts' => $this->header_scripts,
            'footer_scripts' => $this->footer_scripts,
            'seo_meta_description' => $this->seo_meta_description,
            'seo_meta_keywords' => $this->seo_meta_keywords,
            'terms_and_conditions' => $this->terms_and_conditions,
            'privacy_policy' => $this->privacy_policy,
        ]);

        $settings->save();

        $this->dispatch('toastMessage', json_encode([
            'type'=>'success',
            'message' => 'Settings saved successfully!'
        ]));

        // Refresh the existing file paths
        $this->mount();
    }

    public function render()
    {
        return view('livewire.settings.website-settings');
    }
}