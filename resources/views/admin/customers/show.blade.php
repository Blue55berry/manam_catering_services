@extends('layouts.admin')

@section('title', 'View Customer: ' . $customer->name)
@section('page-title', 'Customer Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">
            <i class="fa fa-user"></i> {{ $customer->name }}
        </h2>
        <div>
            <div class="btn-group me-2">
                <button type="button" class="btn-modern dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="background: #10b981; color: white;">
                    <i class="fa fa-share-alt"></i> Share Details
                </button>
                <ul class="dropdown-menu">
                    <li><button class="dropdown-item" id="copyDetailsBtn"><i class="fa fa-copy me-2"></i> Copy to Clipboard</button></li>
                    <li><button class="dropdown-item" id="whatsappShareBtn"><i class="fa fa-whatsapp me-2"></i> Share via WhatsApp</button></li>
                    <li><button class="dropdown-item" id="emailShareBtn"><i class="fa fa-envelope me-2"></i> Share via Email</button></li>
                </ul>
            </div>
            <a href="{{ route('admin.customers.edit', $customer) }}" class="btn-modern btn-warning me-2" style="background: #fbbf24; color: black;">
                <i class="fa fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.customers.index') }}" class="btn-modern" style="background: #6b7280; color: white;">
                <i class="fa fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Basic Information -->
        <div class="col-md-6 mb-4">
            <div class="modern-card h-100">
                <h5 class="mb-4 text-primary"><i class="fa fa-info-circle"></i> Basic Information</h5>
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <th style="width: 140px;">Name:</th>
                            <td>{{ $customer->name }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td><a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a></td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td><a href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a></td>
                        </tr>
                        <tr>
                            <th>Guest Count:</th>
                            <td>{{ $customer->guest_count ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if($customer->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Added On:</th>
                            <td>{{ $customer->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Address Details -->
        <div class="col-md-6 mb-4">
            <div class="modern-card h-100">
                <h5 class="mb-4 text-primary"><i class="fa fa-map-marker"></i> Address Details</h5>
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <th style="width: 140px;">Address:</th>
                            <td>{{ $customer->address ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>City:</th>
                            <td>{{ $customer->city ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>State:</th>
                            <td>{{ $customer->state ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Pincode:</th>
                            <td>{{ $customer->pincode ?? 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Food Preferences -->
        <div class="col-12 mb-4">
            <div class="modern-card">
                <h5 class="mb-4 text-primary"><i class="fa fa-cutlery"></i> Food Preferences</h5>
                @if(!empty($customer->food_preferences) && is_array($customer->food_preferences) && count($customer->food_preferences) > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Category</th>
                                <th>Item Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customer->food_preferences as $pref)
                                <tr>
                                    <td>
                                        @if(isset($pref['category_id']))
                                            @php
                                                $category = \App\Models\MenuCategory::find($pref['category_id']);
                                            @endphp
                                            <span class="badge bg-info">{{ $category ? $category->name : 'Unknown' }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $pref['name'] ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="fa fa-coffee mb-2" style="font-size: 2rem; opacity: 0.5;"></i>
                        <p class="mb-0">No food preferences listed.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Notes -->
        @if($customer->notes)
        <div class="col-12">
            <div class="modern-card">
                <h5 class="mb-3 text-primary"><i class="fa fa-sticky-note"></i> Notes</h5>
                <div class="p-3 bg-light rounded border">
                    {{ $customer->notes }}
                </div>
            </div>
        </div>
        @endif


        <!-- Quotations -->
        <div class="col-12 mb-4">
            <div class="modern-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="text-primary mb-0"><i class="fa fa-file-text-o"></i> Quotations</h5>
                    <a href="{{ route('admin.quotations.create', ['customer_id' => $customer->id]) }}" class="btn-modern btn-modern-primary btn-sm">
                        <i class="fa fa-plus"></i> Create Quotation
                    </a>
                </div>
                
                @if($customer->quotations->count() > 0)
                <div class="row g-4">
                    @foreach($customer->quotations as $quotation)
                        <div class="col-lg-6 col-xl-4">
                            <div class="quotation-card">
                                <div class="quotation-card-header">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h5 class="quotation-number mb-1">
                                                #{{ $loop->iteration }}
                                                <span class="text-muted fw-normal" style="font-size: 0.8rem;">({{ $quotation->quotation_number }})</span>
                                            </h5>
                                            <small class="text-muted">{{ $quotation->created_at->format('M d, Y') }}</small>
                                        </div>
                                        <div>
                                            @if($quotation->status === 'sent')
                                                <span class="badge-modern badge-info">Sent</span>
                                            @elseif($quotation->status === 'accepted')
                                                <span class="badge-modern badge-success">Accepted</span>
                                            @elseif($quotation->status === 'rejected')
                                                <span class="badge-modern badge-danger">Rejected</span>
                                            @else
                                                <span class="badge-modern badge-secondary">Draft</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="quotation-card-body">
                                    @if($quotation->event_type)
                                    <div class="event-info mb-3">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted"><i class="fa fa-calendar me-1"></i> Event</span>
                                            <strong>{{ $quotation->event_type }}</strong>
                                        </div>
                                        @if($quotation->event_date)
                                        <div class="d-flex justify-content-between mt-1">
                                            <span class="text-muted"><i class="fa fa-clock me-1"></i> Date</span>
                                            <span>{{ $quotation->event_date->format('M d, Y') }}</span>
                                        </div>
                                        @endif
                                    </div>
                                    @endif

                                    <div class="quotation-total">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted">Total Amount</span>
                                            <h4 class="mb-0 text-success">₹{{ number_format($quotation->total, 2) }}</h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="quotation-card-footer">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.quotations.show', $quotation) }}" 
                                           class="btn btn-sm btn-primary flex-fill text-white" title="View">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                        <a href="mailto:{{ $customer->email }}?subject=Quotation {{ $quotation->quotation_number }}&body=Please find the attached quotation." 
                                           class="btn btn-sm btn-info flex-fill text-white" title="Send via Email">
                                            <i class="fa fa-envelope"></i> Email
                                        </a>
                                        <form action="{{ route('admin.quotations.destroy', $quotation) }}" 
                                              method="POST" class="d-inline flex-fill">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger w-100" 
                                                    onclick="return confirm('Delete this quotation?')" 
                                                    title="Delete">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="fa fa-file-text-o mb-2" style="font-size: 2rem; opacity: 0.5;"></i>
                        <p class="mb-0">No quotations found for this customer.</p>
                        <a href="{{ route('admin.quotations.create', ['customer_id' => $customer->id]) }}" class="btn btn-sm btn-outline-primary mt-2">
                            Create First Quotation
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* Quotation Card Styles */
.quotation-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
}

.quotation-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.quotation-card-header {
    padding: 1.25rem;
    border-bottom: 1px solid #e5e7eb;
}

.quotation-number {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1B4D3E;
}

.quotation-card-body {
    padding: 1.25rem;
    flex-grow: 1;
}

.customer-info, .event-info {
    font-size: 0.9rem;
}

.quotation-total {
    padding-top: 1rem;
    border-top: 2px dashed #e5e7eb;
    margin-top: 1rem;
}

.quotation-card-footer {
    padding: 1rem 1.25rem;
    background-color: #f9fafb;
    border-top: 1px solid #e5e7eb;
}

.badge-modern {
    padding: 0.35em 0.65em;
    font-size: 0.75em;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
}

.badge-info { background-color: #3b82f6; }
.badge-success { background-color: #10b981; }
.badge-danger { background-color: #ef4444; }
.badge-secondary { background-color: #6b7280; }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const customer = {
        name: "{{ $customer->name }}",
        email: "{{ $customer->email }}",
        phone: "{{ $customer->phone }}",
        guest_count: "{{ $customer->guest_count ?? 'N/A' }}",
        address: "{{ $customer->address ?? '' }}",
        city: "{{ $customer->city ?? '' }}",
        state: "{{ $customer->state ?? '' }}",
        pincode: "{{ $customer->pincode ?? '' }}",
        preferences: @json($customer->food_preferences ?? [])
    };

    function generateShareText() {
        let text = `*Customer Details*\n`;
        text += `Name: ${customer.name}\n`;
        text += `Phone: ${customer.phone}\n`;
        text += `Email: ${customer.email}\n`;
        text += `Guest Count: ${customer.guest_count}\n\n`;

        if (customer.address) {
            text += `*Address:*\n`;
            text += `${customer.address}, ${customer.city}\n`;
            text += `${customer.state} - ${customer.pincode}\n\n`;
        }

        if (customer.preferences && customer.preferences.length > 0) {
            text += `*Food Preferences:*\n`;
            
            // Group by Category if possible, or just list
            // For simplicity in JS without category names map, we list items
            // However, the blade passed pure IDs for category usually, so we might miss names if not careful.
            // The preferences array from DB usually looks like [{category_id: 1, name: 'Item'}]
            // Getting category names in JS is hard without passing a map. 
            // Let's rely on what's available.
            
            customer.preferences.forEach(pref => {
                text += `- ${pref.name || 'Unknown Item'}\n`;
            });
        }
        
        return text;
    }

    // Copy to Clipboard
    document.getElementById('copyDetailsBtn').addEventListener('click', function(e) {
        e.preventDefault();
        const text = generateShareText();
        navigator.clipboard.writeText(text).then(() => {
            alert('Customer details copied to clipboard!');
        }).catch(err => {
            console.error('Failed to copy text: ', err);
            alert('Failed to copy to clipboard.');
        });
    });

    // Share via WhatsApp
    document.getElementById('whatsappShareBtn').addEventListener('click', function(e) {
        e.preventDefault();
        const text = generateShareText();
        const url = `https://wa.me/?text=${encodeURIComponent(text)}`;
        window.open(url, '_blank');
    });

    // Share via Email
    document.getElementById('emailShareBtn').addEventListener('click', function(e) {
        e.preventDefault();
        const text = generateShareText();
        const subject = `Details for ${customer.name}`;
        const body = encodeURIComponent(text);
        const url = `mailto:${customer.email}?subject=${encodeURIComponent(subject)}&body=${body}`;
        window.location.href = url;
    });
});
</script>
@endsection
