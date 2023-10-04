@section('title', __('Settings'))
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h3 class="card-title">General Setting</h3>
                    <button type="submit" class="btn btn-sm btn-primary float-end" wire:click="updateSetting">
                        <i class="bi bi-save me-2"></i> Save changes
                    </button>
                </div>
            </div>
            <form>
                <div class="card-body row g-2">
                    <div class="col-md-6 form-group">
                        <label for="siteName">Site Name</label>
                        <input wire:model="state.site_name" type="text" class="form-control" id="siteName"
                            placeholder="Enter site name">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="siteShortCode">Site Short Code</label>
                        <input wire:model="state.site_short_code" type="text" class="form-control"
                            id="siteShortCode" placeholder="Enter site Short Code">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="siteEmail">Site Email</label>
                        <input wire:model="state.site_email" type="email" class="form-control" id="siteEmail"
                            placeholder="Enter site email">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="siteTitle">Site Title</label>
                        <input wire:model="state.site_title" type="text" class="form-control" id="siteTitle"
                            placeholder="Enter site title">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="footerText">Footer Text</label>
                        <input wire:model="state.footer_text" type="text" class="form-control" id="footerText"
                            placeholder="Enter footer text">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="siteTheme" class="form-label">Site Theme</label>
                        <select wire:model="state.site_theme" class="form-select form-select-sm">
                            <option value="">Choose an option...</option>
                            <option value="light">Light</option>
                            <option value="dark">Dark</option>
                        </select>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="site_description">Descripion</label>
                        <textarea class="form-control" wire:model="state.site_description" rows="5"
                            name="site_description" id="site_description" placeholder="Enter site Descripion"></textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>