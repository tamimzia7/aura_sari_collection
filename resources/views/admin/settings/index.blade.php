@extends('admin.layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Settings</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Settings</li>
            </ol>
        </nav>
    </div>
    <div>
        <button class="btn btn-soft-primary"><i class="fas fa-sync-alt me-1"></i> Reset Defaults</button>
    </div>
</div>

<form action="#" method="POST">
    @csrf

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">General Settings</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Site Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="AURA - Premium Saree Collection">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tagline</label>
                            <input type="text" class="form-control" value="Discover the finest collection of premium sarees">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Site Description</label>
                            <textarea class="form-control" rows="3">AURA is a premium e-commerce platform offering the finest collection of handcrafted sarees, blending traditional artistry with contemporary elegance.</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Default Currency</label>
                            <select class="form-select">
                                <option value="USD" selected>USD ($)</option>
                                <option value="INR">INR (₹)</option>
                                <option value="EUR">EUR (€)</option>
                                <option value="GBP">GBP (£)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Currency Symbol Position</label>
                            <select class="form-select">
                                <option value="before" selected>Before ($249)</option>
                                <option value="after">After (249$)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Theme Colors</div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label class="form-label">Primary Color</label>
                            <div class="color-input-wrapper">
                                <input type="color" value="#8B5CF6">
                                <input type="text" class="form-control" value="#8B5CF6">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Secondary Color</label>
                            <div class="color-input-wrapper">
                                <input type="color" value="#1a1d23">
                                <input type="text" class="form-control" value="#1a1d23">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Accent Color</label>
                            <div class="color-input-wrapper">
                                <input type="color" value="#10b981">
                                <input type="text" class="form-control" value="#10b981">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Contact Information</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" value="hello@aurasaree.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" class="form-control" value="+1 (555) 123-4567">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Address Line 1</label>
                            <input type="text" class="form-control" value="123 Fashion Street">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Address Line 2</label>
                            <input type="text" class="form-control" value="Suite 100">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" value="New York">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">State</label>
                            <input type="text" class="form-control" value="NY">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">ZIP Code</label>
                            <input type="text" class="form-control" value="10001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Country</label>
                            <select class="form-select">
                                <option>United States</option>
                                <option selected>India</option>
                                <option>United Kingdom</option>
                                <option>Canada</option>
                                <option>Australia</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Timezone</label>
                            <select class="form-select">
                                <option>UTC</option>
                                <option>EST</option>
                                <option>PST</option>
                                <option selected>Asia/Kolkata (IST)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">Store Logo</div>
                <div class="card-body text-center">
                    <div style="width:120px;height:120px;border-radius:16px;background:#f1f3f5;margin:0 auto 16px;display:flex;align-items:center;justify-content:center;font-size:48px;font-weight:700;color:var(--primary-color);cursor:pointer;border:2px dashed #e2e8f0;" onclick="document.getElementById('storeLogo').click()">
                        A
                    </div>
                    <p style="font-size:13px;color:#6c757d;margin-bottom:16px;">Click to upload store logo<br><small>PNG, JPG, WEBP (max 2MB)</small></p>
                    <input type="file" id="storeLogo" style="display:none;" accept="image/*">
                    <div class="d-grid">
                        <button type="button" class="btn btn-light btn-sm">Remove Logo</button>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Maintenance Mode</div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <div class="fw-semibold">Enable Maintenance Mode</div>
                            <div style="font-size:12px;color:#6c757d;">Only admins can access the site</div>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch">
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Maintenance Message</label>
                        <textarea class="form-control" rows="2" placeholder="We'll be back soon!">We are currently performing scheduled maintenance. We'll be back shortly!</textarea>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Social Links</div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-3">
                        <div>
                            <label class="form-label"><i class="fab fa-facebook me-2" style="color:#1877F2;"></i> Facebook</label>
                            <input type="url" class="form-control" placeholder="https://facebook.com/aurasaree">
                        </div>
                        <div>
                            <label class="form-label"><i class="fab fa-instagram me-2" style="color:#E4405F;"></i> Instagram</label>
                            <input type="url" class="form-control" placeholder="https://instagram.com/aurasaree">
                        </div>
                        <div>
                            <label class="form-label"><i class="fab fa-pinterest me-2" style="color:#BD081C;"></i> Pinterest</label>
                            <input type="url" class="form-control" placeholder="https://pinterest.com/aurasaree">
                        </div>
                        <div>
                            <label class="form-label"><i class="fab fa-youtube me-2" style="color:#FF0000;"></i> YouTube</label>
                            <input type="url" class="form-control" placeholder="https://youtube.com/@aurasaree">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-1"></i> Save Settings
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('input[type="color"]').on('input', function() {
        $(this).closest('.color-input-wrapper').find('input[type="text"]').val($(this).val());
    });

    $('.color-input-wrapper input[type="text"]').on('input', function() {
        const val = $(this).val();
        if (/^#[0-9A-F]{6}$/i.test(val)) {
            $(this).closest('.color-input-wrapper').find('input[type="color"]').val(val);
        }
    });
});
</script>
@endpush
