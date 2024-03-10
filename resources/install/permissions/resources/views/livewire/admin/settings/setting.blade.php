@section('title', __('Settings'))
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h3 class="card-title">General Setting</h3>
                    <button type="submit" class="btn btn-sm btn-primary float-end" wire:click="updateSettings">
                        <i class="bi-save me-2"></i> Save changes
                    </button>
                </div>
            </div>
            <form>
                <div class="card-body row g-2">
                    <div class="col-md-6 form-group">
                        <label for="siteName">Site Name</label>
                        <input wire:model="settings.site_name" type="text" class="form-control" id="siteName"
                            placeholder="Enter site name">
                        @error('settings.site_name')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="siteShortCode">Site Short Code</label>
                        <input wire:model="settings.site_short_code" type="text" class="form-control" id="siteShortCode"
                            placeholder="Enter site Short Code">
                        @error('settings.site_short_code')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="siteEmail">Site Email</label>
                        <input wire:model="settings.site_email" type="email" class="form-control" id="siteEmail"
                            placeholder="Enter site email">
                        @error('settings.site_email')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="sitePhone">Site Phone</label>
                        <input wire:model="settings.site_phone" type="text" class="form-control" id="sitePhone"
                            placeholder="Enter site Phone Number">
                        @error('settings.site_phone')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="siteLogo">Site Logo</label>
                        <input wire:model.live="settings.site_logo" type="file" class="form-control" id="siteLogo">
                        @error('settings.site_logo')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="siteTheme" class="form-label">Site Theme</label>
                        <select wire:model="settings.site_theme" class="form-select form-select-sm" id="siteTheme">
                            <option value="">Choose an option...</option>
                            <option value="light">Light</option>
                            <option value="dark">Dark</option>
                        </select>
                        @error('settings.site_theme')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="siteCurrency" class="form-label">Site Currency</label>
                        <select wire:model="settings.site_currency" class="form-select form-select-sm" id="siteCurrency">
                            <option value="">Choose an option...</option>
                            <option value="kes">Kenya Shillings</option>
                            <option value="usd">US Dollars</option>
                        </select>
                        @error('settings.site_currency')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="siteDateFormat" class="form-label">Date Format</label>
                        <select wire:model="settings.date_format" class="form-select form-select-sm" id="siteDateFormat">
                            <option value="">Choose an option...</option>
                            <option value="m/d/Y">MM/DD/YYYY</option>
                            <option value="d/m/Y">DD/MM/YYYY</option>
                            <option value="Y-m-d">YYYY-MM-DD</option>
                            <option value="F j, Y">Month DD, YYYY</option>
                            <option value="j F Y">DD Month YYYY</option>
                        </select>
                        @error('settings.date_format')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="siteTimeFormat" class="form-label">Time Format</label>
                        <select wire:model="settings.time_format" class="form-select form-select-sm" id="siteTimeFormat">
                            <option value="">Choose an option...</option>
                            <option value="H:i:s">24 Hrs</option>
                            <option value="g:i a">12 Hrs</option>
                        </select>
                        @error('settings.time_format')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="footerText">Footer Text</label>
                        <input wire:model="settings.footer_text" type="text" class="form-control" id="footerText"
                            placeholder="Enter footer text">
                        @error('settings.footer_text')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="siteDescription">Site Descripion</label>
                        <textarea class="form-control" wire:model="settings.site_description" rows="5" id="siteDescription"
                            placeholder="Enter site Descripion"></textarea>
                        @error('settings.site_description')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
