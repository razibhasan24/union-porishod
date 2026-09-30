@php
    $grouped = [];
    foreach ($permissions as $module => $groups) {
        foreach ($groups as $group => $perms) {
            $grouped[$module ?? 'other'][$group ?? 'general'] = $perms;
        }
    }
@endphp

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white"><strong>পারমিশন নির্বাচন</strong></div>
    <div class="card-body">
        @foreach($grouped as $moduleName => $groups)
        <div class="mb-4 border-bottom pb-3">
            <h6 class="text-primary">
                <i class="bi bi-folder"></i> {{ ucfirst($moduleName) }} Module
                <button type="button" class="btn btn-sm btn-outline-primary ms-2 module-toggle" data-module="{{ $moduleName }}">
                    সব সিলেক্ট
                </button>
            </h6>

            @foreach($groups as $groupName => $perms)
            <div class="ms-3 mb-2">
                <small class="text-muted d-block mb-1"><strong>{{ $groupName }}</strong></small>
                <div class="row">
                    @foreach($perms as $perm)
                    <div class="col-md-3">
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="{{ $perm->name }}" 
                                class="form-check-input perm-check perm-{{ $moduleName }}"
                                id="perm-{{ $perm->id }}"
                                {{ isset($rolePermissions) && in_array($perm->name, $rolePermissions) ? 'checked' : '' }}>
                            <label class="form-check-label small" for="perm-{{ $perm->id }}">
                                {{ $perm->label_bn ?? $perm->name }}
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.module-toggle').forEach(btn => {
    btn.addEventListener('click', function() {
        const moduleName = this.dataset.module;
        const checks = document.querySelectorAll('.perm-' + moduleName);
        const allChecked = Array.from(checks).every(c => c.checked);
        checks.forEach(c => c.checked = !allChecked);
        this.textContent = allChecked ? 'সব সিলেক্ট' : 'সব আনসিলেক্ট';
    });
});
</script>
@endpush