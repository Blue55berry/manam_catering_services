@extends('layouts.admin')

@section('title', 'Import Menu Items')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="fa fa-upload"></i> Import Menu Items</h2>
        <a href="{{ route('admin.menu-items.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Back to Menu Items
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fa fa-exclamation-circle"></i> {!! session('error') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="dashboard-widget">
                <h5 class="widget-title"><i class="fa fa-cloud-upload"></i> Upload CSV/Excel File</h5>
                
                <form action="{{ route('admin.menu-items.process-import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="import-dropzone mb-4">
                        <input type="file" class="form-control @error('file') is-invalid @enderror" 
                               id="file" name="file" accept=".csv,.xlsx,.xls" required>
                        <div class="dropzone-label">
                            <i class="fa fa-cloud-upload fa-3x mb-3"></i>
                            <h5>Choose a file or drag it here</h5>
                            <p class="text-muted">Supported formats: CSV, XLSX, XLS (Max: 5MB)</p>
                        </div>
                        @error('file')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.menu-items.index') }}" class="btn btn-secondary">
                            <i class="fa fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-upload"></i> Import Items
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Instructions Card -->
            <div class="dashboard-widget mb-4">
                <h5 class="widget-title"><i class="fa fa-info-circle"></i> Instructions</h5>
                <ol class="mb-0">
                    <li class="mb-2">Download the template file below</li>
                    <li class="mb-2">Fill in your menu items data</li>
                    <li class="mb-2">Upload the completed file</li>
                    <li>Review imported items in the menu list</li>
                </ol>
                
                <hr>
                
                <a href="{{ route('admin.menu-items.template') }}" class="btn btn-success w-100">
                    <i class="fa fa-download"></i> Download Template
                </a>
            </div>

            <!-- Format Guide Card -->
            <div class="dashboard-widget">
                <h5 class="widget-title"><i class="fa fa-table"></i> Format Guide</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Column</th>
                                <th>Required</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>category</td>
                                <td><span class="badge bg-danger">Yes</span></td>
                            </tr>
                            <tr>
                                <td>name</td>
                                <td><span class="badge bg-danger">Yes</span></td>
                            </tr>
                            <tr>
                                <td>price</td>
                                <td><span class="badge bg-danger">Yes</span> <small class="text-muted">(e.g. 100 or 100.50)</small></td>
                            </tr>
                            <tr>
                                <td>description</td>
                                <td><span class="badge bg-secondary">No</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="alert alert-info mt-3 mb-0">
                    <small>
                        <strong>Note:</strong> Category names must match existing categories in the system.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.import-dropzone {
    position: relative;
    border: 3px dashed #d1d5db;
    border-radius: 12px;
    padding: 40px;
    text-align: center;
    background: #f9fafb;
    transition: all 0.3s ease;
}

.import-dropzone:hover {
    border-color: var(--admin-primary);
    background: rgba(16, 185, 129, 0.05);
}

.import-dropzone input[type="file"] {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}

.dropzone-label {
    pointer-events: none;
}

.dropzone-label i {
    color: var(--admin-primary);
}

.import-dropzone:hover .dropzone-label i {
    transform: scale(1.1);
    transition: transform 0.3s ease;
}

.gap-2 {
    gap: 0.5rem;
}
</style>

<script>
document.getElementById('file').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name;
    if (fileName) {
        const label = document.querySelector('.dropzone-label h5');
        label.textContent = '✓ ' + fileName;
        label.style.color = 'var(--admin-primary)';
    }
});
</script>
@endsection
