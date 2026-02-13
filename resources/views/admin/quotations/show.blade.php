@extends('layouts.admin')

@section('title', 'View Quotation')
@section('page-title', 'View Quotation')

@section('content')
<div class="container-fluid">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.quotations.index') }}" class="btn-modern" style="background: #6b7280; color: white;">
            <i class="fa fa-arrow-left"></i> Back
        </a>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.quotations.edit', $quotation) }}" class="btn-modern" style="background: #f59e0b; color: white;">
                <i class="fa fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.quotations.pdf', $quotation) }}" class="btn-modern" style="background: #8B6F47; color: white;">
                <i class="fa fa-download"></i> Download PDF
            </a>
            @if($quotation->customer_phone)
            <button onclick="shareQuotationPDF(this, '{{ route('admin.quotations.pdf', $quotation) }}', '{{ $quotation->quotation_number }}', '{{ route('admin.quotations.whatsapp', $quotation) }}')" class="btn-modern btn-modern-success">
                <i class="fa fa-whatsapp"></i> Share PDF
            </button>
            @endif
            <button class="btn-modern" style="background: #3b82f6; color: white;" data-bs-toggle="modal" data-bs-target="#emailModal">
                <i class="fa fa-envelope"></i> Send Email
            </button>
            <button onclick="window.print()" class="btn-modern" style="background: #8b5cf6; color: white;">
                <i class="fa fa-print"></i> Print
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="modern-card quotation-detail-card">
        <div class="modern-card-header" style="background: white; border-bottom: 2px solid #e5e7eb; padding: 2rem;">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <img src="{{ asset('assets/images/main/logo.png') }}" alt="Manam Logo" style="height: 60px; margin-bottom: 10px;">
                    <div style="font-size: 0.85rem; color: #666; line-height: 1.6;">
                        <strong>Manam Catering HQ</strong><br>
                        123 Culinary Road, Food District<br>
                        Coimbatore, Tamil Nadu 841002<br>
                        GSTIN: 33AAAAAA0000A1Z5
                    </div>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 2rem; font-weight: bold; color: #1a1a1a; margin-bottom: 0.5rem;">QUOTATION</div>
                    <div style="font-size: 0.9rem; color: #8B6F47; margin-bottom: 0.5rem;">#{{ $quotation->quotation_number }}</div>
                    @if($quotation->status === 'sent')
                        <span style="display: inline-block; padding: 0.4rem 1rem; background: #8B6F47; color: white; border-radius: 4px; font-size: 0.75rem; font-weight: bold; text-transform: uppercase;">SENT</span>
                    @elseif($quotation->status === 'accepted')
                        <span style="display: inline-block; padding: 0.4rem 1rem; background: #16a34a; color: white; border-radius: 4px; font-size: 0.75rem; font-weight: bold; text-transform: uppercase;">ACCEPTED</span>
                    @elseif($quotation->status === 'rejected')
                        <span style="display: inline-block; padding: 0.4rem 1rem; background: #dc2626; color: white; border-radius: 4px; font-size: 0.75rem; font-weight: bold; text-transform: uppercase;">REJECTED</span>
                    @else
                        <span style="display: inline-block; padding: 0.4rem 1rem; background: #8B6F47; color: white; border-radius: 4px; font-size: 0.75rem; font-weight: bold; text-transform: uppercase;">DRAFT</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="modern-card-body">
            <!-- Customer & Event Info -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="info-section">
                        <h5 class="section-heading"><i class="fa fa-user me-2"></i>Customer Information</h5>
                        <div class="info-item">
                            <span class="info-label">Name:</span>
                            <span class="info-value">{{ $quotation->customer_name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email:</span>
                            <span class="info-value">{{ $quotation->customer_email }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Phone:</span>
                            <span class="info-value">{{ $quotation->customer_phone ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-section">
                        <h5 class="section-heading"><i class="fa fa-calendar me-2"></i>Event Details</h5>
                        <div class="info-item">
                            <span class="info-label">Event Type:</span>
                            <span class="info-value">{{ $quotation->event_type ?? 'General' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Event Date:</span>
                            <span class="info-value">{{ $quotation->event_date ? $quotation->event_date->format('F d, Y') : 'TBD' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Guest Count:</span>
                            <span class="info-value">{{ $quotation->guest_count ?? 'TBD' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <hr style="border-top: 2px dashed #e5e7eb; margin: 2rem 0;">

            <!-- Items Table -->
            <h5 class="section-heading mb-3"><i class="fa fa-list me-2"></i>Items</h5>
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th width="50">#</th>
                            <th>Item Name</th>
                            <th width="120" class="text-center">Quantity</th>
                            <th width="150" class="text-end">Price</th>
                            <th width="150" class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($quotation->items && count($quotation->items) > 0)
                            @foreach($quotation->items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $item['name'] }}</strong></td>
                                <td class="text-center">{{ $item['quantity'] }}</td>
                                <td class="text-end">₹{{ number_format($item['price'], 2) }}</td>
                                <td class="text-end"><strong>₹{{ number_format($item['quantity'] * $item['price'], 2) }}</strong></td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No items added yet</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Notes & Totals -->
            <div class="row mt-4">
                <div class="col-md-6">
                    @if($quotation->notes)
                    <div class="info-section">
                        <h5 class="section-heading"><i class="fa fa-sticky-note me-2"></i>Notes</h5>
                        <div class="notes-box">
                            {!! nl2br(e($quotation->notes)) !!}
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="totals-box">
                        <div class="total-row">
                            <span class="total-label">Subtotal:</span>
                            <span class="total-value">₹{{ number_format($quotation->subtotal, 2) }}</span>
                        </div>
                        <div class="total-row">
                            <span class="total-label">Tax (18% GST):</span>
                            <span class="total-value">₹{{ number_format($quotation->tax, 2) }}</span>
                        </div>
                        <div class="total-row">
                            <span class="total-label">Discount:</span>
                            <span class="total-value text-danger">-₹{{ number_format($quotation->discount, 2) }}</span>
                        </div>
                        <hr style="margin: 0.75rem 0;">
                        <div class="total-row grand-total">
                            <span class="total-label">Total Amount:</span>
                            <span class="total-value">₹{{ number_format($quotation->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Email Modal -->
<div class="modal fade" id="emailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.quotations.email', $quotation) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Send Quotation via Email</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Recipient Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $quotation->customer_email }}" required>
                    </div>
                    <div class="alert alert-info mb-0">
                        <small><i class="fa fa-info-circle me-1"></i>The quotation will be sent as a PDF attachment.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-modern btn-modern-primary">
                        <i class="fa fa-send"></i> Send Email
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
@media print {
    @page {
        size: auto;
        margin: 5mm;
    }

    /* Hide ALL Admin Interface Elements */
    #adminSidebar, 
    .admin-sidebar,
    .admin-header, 
    .header-actions,
    .header-search,
    .header-notifications,
    .mobile-menu-toggle,
    #mobileMenuToggle,
    .sidebar-toggle,
    #sidebarToggle,
    .btn-modern, 
    .btn,
    .modal, 
    .alert,
    .mb-4.d-flex.justify-content-between { 
        display: none !important; 
        height: 0 !important;
        width: 0 !important;
        overflow: hidden !important;
    }

    /* Reset Main Layout for Full Width */
    html, body {
        background: white !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: visible !important;
    }

    .admin-wrapper, .admin-main, .admin-content, .container-fluid {
        background: white !important;
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        display: block !important;
        flex: none !important; /* Disable flex affecting layout */
    }

    /* Card Styling */
    .modern-card, .quotation-detail-card { 
        box-shadow: none !important; 
        border: none !important; 
        width: 100% !important;
    }

    /* Force background colors to print */
    .notes-box, .section-heading, .modern-card-header, th, .badge, span {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
    
    /* Layout Adjustments */
    .modern-card-header {
        padding: 10px 0 !important;
        border-bottom: 2px solid #000 !important;
    }

    /* Ensure columns float or flex correctly in print */
    .row {
        display: flex !important;
        flex-wrap: nowrap !important;
    }
    .col-md-6 {
        width: 50% !important;
        flex: 0 0 50% !important;
    }
}

.quotation-detail-card {
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.info-section {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    height: 100%;
}

.section-heading {
    color: #8B6F47;
    font-weight: 700;
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

.info-item {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid #e5e7eb;
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    color: #6b7280;
    font-weight: 500;
}

.info-value {
    color: #111827;
    font-weight: 600;
}

.notes-box {
    background: #fffbeb;
    border: 1px solid #fef3c7;
    padding: 1rem;
    border-radius: 6px;
    color: #78350f;
    line-height: 1.6;
}

.totals-box {
    background: white;
    border: 1px solid #e5e7eb;
    padding: 1.5rem;
    border-radius: 8px;
}

.total-row {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
}

.total-label {
    color: #374151;
    font-weight: 500;
}

.total-value {
    color: #111827;
    font-weight: 600;
}

.grand-total {
    margin-top: 0.5rem;
}

.grand-total .total-label {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1a1a1a;
}

.grand-total .total-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #8B6F47;
}
</style>
@endsection

@push('scripts')
<script>
async function shareQuotationPDF(btn, url, number, fallbackUrl) {
    const originalContent = btn.innerHTML;
    
    try {
        // Feature detection
        if (!navigator.share || !navigator.canShare) {
            console.log("Web Share API not supported, falling back.");
            window.open(fallbackUrl, '_blank');
            return;
        }

        // Show loading state
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Preparing...';
        btn.disabled = true;

        // Fetch the PDF
        const response = await fetch(url);
        if (!response.ok) throw new Error('Network response was not ok');
        const blob = await response.blob();
        
        // Create File object
        const file = new File([blob], `Quotation-${number}.pdf`, { type: 'application/pdf' });
        
        // Check if file sharing is supported
        if (!navigator.canShare({ files: [file] })) {
             console.log("File sharing not supported, falling back.");
             window.open(fallbackUrl, '_blank');
             return;
        }

        // Trigger Share
        await navigator.share({
            files: [file],
            title: `Quotation #${number}`,
            text: `Here is the quotation #${number} from Manam Catering Service.`
        });
        
    } catch (err) {
        // Ignore user cancellation errors
        if (err.name !== 'AbortError') {
             console.error('Share failed:', err);
             // If meaningful error, try fallback
             window.open(fallbackUrl, '_blank');
        }
    } finally {
        // Reset button
        btn.innerHTML = originalContent;
        btn.disabled = false;
    }
}
</script>
@endpush
