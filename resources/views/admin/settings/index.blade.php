@extends('admin.layouts.admin')

@section('title', 'Settings')

@section('content')
@php
$setting = fn($key, $default = '') => $settings->flatten()->firstWhere('key', $key)?->value ?? $default;
$groups = [
    'general' => ['label' => 'General Settings', 'icon' => 'fa-cog', 'fields' => [
        ['key' => 'site_name', 'label' => 'Site Name', 'type' => 'text', 'required' => true],
        ['key' => 'site_tagline', 'label' => 'Tagline', 'type' => 'text'],
        ['key' => 'site_description', 'label' => 'Site Description', 'type' => 'textarea', 'rows' => 3],
        ['key' => 'currency', 'label' => 'Default Currency', 'type' => 'select', 'options' => ['USD' => 'USD ($)', 'INR' => 'INR (₹)', 'EUR' => 'EUR (€)', 'GBP' => 'GBP (£)']],
        ['key' => 'currency_symbol', 'label' => 'Currency Symbol', 'type' => 'select', 'options' => ['$' => '$', '₹' => '₹', '€' => '€', '£' => '£']],
    ]],
    'contact' => ['label' => 'Contact Information', 'icon' => 'fa-address-card', 'fields' => [
        ['key' => 'contact_email', 'label' => 'Contact Email', 'type' => 'email'],
        ['key' => 'contact_phone', 'label' => 'Contact Phone', 'type' => 'text'],
        ['key' => 'contact_address', 'label' => 'Contact Address', 'type' => 'textarea', 'rows' => 2],
    ]],
    'social' => ['label' => 'Social Links', 'icon' => 'fa-share-alt', 'fields' => [
        ['key' => 'social_facebook', 'label' => 'Facebook', 'type' => 'url', 'icon' => 'fab fa-facebook', 'icon_color' => '#1877F2'],
        ['key' => 'social_instagram', 'label' => 'Instagram', 'type' => 'url', 'icon' => 'fab fa-instagram', 'icon_color' => '#E4405F'],
        ['key' => 'social_whatsapp', 'label' => 'WhatsApp', 'type' => 'text', 'icon' => 'fab fa-whatsapp', 'icon_color' => '#25D366'],
        ['key' => 'social_youtube', 'label' => 'YouTube', 'type' => 'url', 'icon' => 'fab fa-youtube', 'icon_color' => '#FF0000'],
    ]],
    'appearance' => ['label' => 'Appearance', 'icon' => 'fa-palette', 'fields' => [
        ['key' => 'logo_path', 'label' => 'Logo URL', 'type' => 'text', 'help' => 'Enter the URL or path for the store logo'],
        ['key' => 'favicon_path', 'label' => 'Favicon URL', 'type' => 'text', 'help' => 'Enter the URL or path for the favicon'],
        ['key' => 'footer_text', 'label' => 'Footer Text', 'type' => 'text'],
    ]],
];
@endphp

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Settings</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Settings</li>
            </ol>
        </nav>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf

    <div class="row g-4">
        <div class="col-lg-8">
            @foreach (['general', 'contact'] as $groupKey)
                @php $group = $groups[$groupKey]; @endphp
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas {{ $group['icon'] }} me-2"></i> {{ $group['label'] }}
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach ($group['fields'] as $field)
                                @php
                                    $fieldKey = $field['key'];
                                    $fieldValue = old("settings.$fieldKey", $setting($fieldKey));
                                    $fieldName = "settings[$fieldKey]";
                                    $errorKey = "settings.$fieldKey";
                                    $halfWidth = in_array($field['type'], ['textarea']) ? 'col-12' : 'col-md-6';
                                @endphp
                                <div class="{{ $halfWidth }}">
                                    <label for="{{ $fieldKey }}" class="form-label">
                                        {{ $field['label'] }}
                                        @if (!empty($field['required']))
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>

                                    @if ($field['type'] === 'textarea')
                                        <textarea name="{{ $fieldName }}" id="{{ $fieldKey }}"
                                            class="form-control @error($errorKey) is-invalid @enderror"
                                            rows="{{ $field['rows'] ?? 3 }}" {{ !empty($field['required']) ? 'required' : '' }}>{{ $fieldValue }}</textarea>
                                    @elseif ($field['type'] === 'select')
                                        <select name="{{ $fieldName }}" id="{{ $fieldKey }}"
                                            class="form-select @error($errorKey) is-invalid @enderror"
                                            {{ !empty($field['required']) ? 'required' : '' }}>
                                            <option value="">Select {{ $field['label'] }}</option>
                                            @foreach ($field['options'] as $optValue => $optLabel)
                                                <option value="{{ $optValue }}" {{ $fieldValue == $optValue ? 'selected' : '' }}>{{ $optLabel }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input type="{{ $field['type'] }}" name="{{ $fieldName }}" id="{{ $fieldKey }}"
                                            class="form-control @error($errorKey) is-invalid @enderror"
                                            value="{{ $fieldValue }}" {{ !empty($field['required']) ? 'required' : '' }}>
                                    @endif

                                    @error($errorKey)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="col-lg-4">
            @foreach (['social', 'appearance'] as $groupKey)
                @php $group = $groups[$groupKey]; @endphp
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas {{ $group['icon'] }} me-2"></i> {{ $group['label'] }}
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column gap-3">
                            @foreach ($group['fields'] as $field)
                                @php
                                    $fieldKey = $field['key'];
                                    $fieldValue = old("settings.$fieldKey", $setting($fieldKey));
                                    $fieldName = "settings[$fieldKey]";
                                    $errorKey = "settings.$fieldKey";
                                @endphp
                                <div>
                                    <label for="{{ $fieldKey }}" class="form-label">
                                        @if (!empty($field['icon']))
                                            <i class="{{ $field['icon'] }} me-2" style="color: {{ $field['icon_color'] ?? '#6c757d' }};"></i>
                                        @endif
                                        {{ $field['label'] }}
                                    </label>

                                    @if ($field['type'] === 'textarea')
                                        <textarea name="{{ $fieldName }}" id="{{ $fieldKey }}"
                                            class="form-control @error($errorKey) is-invalid @enderror"
                                            rows="{{ $field['rows'] ?? 3 }}">{{ $fieldValue }}</textarea>
                                    @elseif ($field['type'] === 'select')
                                        <select name="{{ $fieldName }}" id="{{ $fieldKey }}"
                                            class="form-select @error($errorKey) is-invalid @enderror">
                                            <option value="">Select {{ $field['label'] }}</option>
                                            @foreach ($field['options'] as $optValue => $optLabel)
                                                <option value="{{ $optValue }}" {{ $fieldValue == $optValue ? 'selected' : '' }}>{{ $optLabel }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input type="{{ $field['type'] }}" name="{{ $fieldName }}" id="{{ $fieldKey }}"
                                            class="form-control @error($errorKey) is-invalid @enderror"
                                            value="{{ $fieldValue }}" placeholder="{{ $field['help'] ?? '' }}">
                                    @endif

                                    @if (!empty($field['help']))
                                        <div class="form-text">{{ $field['help'] }}</div>
                                    @endif

                                    @error($errorKey)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach

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
