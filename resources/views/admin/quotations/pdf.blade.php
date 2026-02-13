<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quotation - {{ $quotation->quotation_number }}</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 40px;
            color: #333;
            background: #fff;
            line-height: 1.5;
            font-size: 14px;
        }
        
        /* Header */
        .header {
            width: 100%;
            margin-bottom: 50px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .logo-cell {
            width: 50%;
            vertical-align: top;
        }
        .invoice-info-cell {
            width: 50%;
            text-align: right;
            vertical-align: top;
        }
        
        .logo {
            max-width: 150px;
            height: auto;
            margin-bottom: 15px;
        }
        
        .company-address {
            font-size: 12px;
            color: #666;
            line-height: 1.4;
        }

        /* Invoice Title & Details */
        .invoice-title {
            font-size: 42px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0 0 5px 0;
            line-height: 1;
        }
        
        .invoice-hash {
            color: #bfa15f;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 8px;
        }
        
        .invoice-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .status-paid { background: #d4edda; color: #155724; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-generated { background: #e2e3e5; color: #383d41; }

        /* Bill To Section */
        .bill-to-section {
            background: #fdfdfd; 
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
            padding: 25px 20px;
            margin-bottom: 40px;
            margin-left: -40px;
            margin-right: -40px;
        }
        
        .bill-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .bill-left {
            width: 60%;
            vertical-align: top;
            padding-right: 20px;
        }
        .bill-right {
            width: 40%;
            vertical-align: top;
            text-align: right;
        }
        
        .label {
            font-size: 10px;
            text-transform: uppercase;
            color: #999;
            letter-spacing: 1px;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        .client-name {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        
        .client-detail {
            font-size: 13px;
            color: #555;
            line-height: 1.4;
        }
        
        .meta-group {
            margin-bottom: 15px;
        }
        .meta-group:last-child {
            margin-bottom: 0;
        }
        
        .meta-value {
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .items-table th {
            text-align: left;
            padding: 12px 10px;
            font-size: 11px;
            text-transform: uppercase;
            color: #bfa15f;
            font-weight: bold;
            border-bottom: 2px solid #eee;
            letter-spacing: 0.5px;
        }
        .items-table td {
            padding: 15px 10px;
            border-bottom: 1px solid #f9f9f9;
            font-size: 13px;
            color: #333;
            vertical-align: top;
        }
        .items-table tr:last-child td {
            border-bottom: 2px solid #eee;
        }
        
        .col-num { width: 5%; color: #bbb; }
        .col-desc { width: 45%; }
        .col-qty { width: 10%; text-align: center; }
        .col-price { width: 20%; text-align: right; }
        .col-total { width: 20%; text-align: right; font-weight: bold; }
        
        .item-name {
            font-weight: 600;
            display: block;
            margin-bottom: 4px;
            color: #333;
        }
        .item-desc {
            font-size: 11px;
            color: #888;
        }

        /* Totals & Notes Layout */
        .footer-layout {
            width: 100%;
            border-collapse: collapse;
        }
        .footer-left {
            width: 50%;
            vertical-align: top;
            padding-right: 40px;
        }
        .footer-right {
            width: 50%;
            vertical-align: top;
        }
        
        /* Notes */
        .notes-title {
            font-size: 11px;
            text-transform: uppercase;
            color: #bfa15f;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .notes-content ul {
            padding-left: 15px;
            margin: 0;
        }
        .notes-content li {
            font-size: 11px;
            color: #666;
            margin-bottom: 5px;
        }

        /* Totals Box */
        .total-row {
            display: flex; /* Flex doesn't work well in dompdf sometimes, tables are safer */
            width: 100%;
            margin-bottom: 8px;
            font-size: 13px;
            color: #555;
        }
        
        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 5px 0;
            text-align: right;
        }
        .totals-label {
            color: #666;
            padding-right: 20px !important;
        }
        .totals-value {
            color: #333;
            font-weight: 500;
            width: 120px;
        }
        
        .grand-total-row td {
            padding-top: 15px;
            border-top: 2px solid #eee;
            color: #bfa15f;
            font-weight: bold;
            font-size: 18px;
        }
        .grand-total-label {
            color: #333 !important;
            font-size: 14px !important;
        }

        /* Bottom Footer */
        .page-footer {
            margin-top: 60px;
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 20px;
            font-size: 10px;
            color: #aaa;
        }
        
        .signature-box {
            text-align: right;
            margin-top: 40px;
        }
        .auth-sign {
            font-family: 'Times New Roman', serif;
            font-size: 24px;
            color: #ddd;
            margin-bottom: 5px;
            font-style: italic;
        }
        .auth-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #999;
            letter-spacing: 1px;
        }
        
        /* Utility */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <table class="header-table">
            <tr>
                <td class="logo-cell">
                    <img src="{{ public_path('assets/images/main/logo.png') }}" alt="Manam Logo" class="logo">
                    <div class="company-address">
                        <strong>Manam Catering HQ</strong><br>
                        123 Culinary Road, Food District<br>
                        Coimbatore, Tamil Nadu 641002<br>
                        GSTIN: 33AAAAAA0000A1Z5
                    </div>
                </td>
                <td class="invoice-info-cell">
                    <h1 class="invoice-title">INVOICE</h1>
                    <div class="invoice-hash">#{{ $quotation->quotation_number }}</div>
                    
                    @if($quotation->status == 'accepted')
                        <span class="invoice-status status-paid">PAID</span>
                    @elseif($quotation->status == 'sent')
                        <span class="invoice-status status-pending">SENT</span>
                    @else
                        <!-- <span class="invoice-status status-generated">{{ strtoupper($quotation->status) }}</span> -->
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- Bill To Section -->
    <div class="bill-to-section">
        <table class="bill-table">
            <tr>
                <td class="bill-left">
                    <div class="label">Bill To</div>
                    <div class="client-name">{{ $quotation->customer_name }}</div>
                    <div class="client-detail">
                        {{ $quotation->customer_address ?? 'Address not provided' }}<br>
                        {{ $quotation->customer_phone }}<br>
                        {{ $quotation->customer_email }}
                    </div>
                </td>
                <td class="bill-right">
                    <div class="meta-group">
                        <div class="label">Invoice Date</div>
                        <div class="meta-value">{{ $quotation->created_at->format('d-m-Y') }}</div>
                    </div>
                    <div class="meta-group">
                        <div class="label">Event Type</div>
                        <div class="meta-value">{{ $quotation->event_type ?? 'Catering Service' }}</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Items Table -->
    <table class="items-table">
        <thead>
            <tr>
                <th class="col-num">#</th>
                <th class="col-desc">Description</th>
                <th class="col-qty">Pax/Qty</th>
                <th class="col-price">Rate per Plate</th>
                <th class="col-total">Total</th>
            </tr>
        </thead>
        <tbody>
            @if($quotation->items && count($quotation->items) > 0)
                @foreach($quotation->items as $index => $item)
                <tr>
                    <td class="col-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="col-desc">
                        <span class="item-name">{{ $item['name'] }}</span>
                        <!-- <span class="item-desc">Premium Service</span> -->
                    </td>
                    <td class="col-qty">{{ $item['quantity'] }}</td>
                    <td class="col-price">₹ {{ number_format($item['price'], 2) }}</td>
                    <td class="col-total">₹ {{ number_format($item['quantity'] * $item['price'], 2) }}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center" style="padding: 30px; color: #999;">No items added</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Footer Layout -->
    <table class="footer-layout">
        <tr>
            <td class="footer-left">
                <div class="notes-title">Terms & Conditions</div>
                <div class="notes-content">
                    <ul>
                        <li>All payments are due within 7 days of event completion.</li>
                        <li>PAX count confirmed 48 hours prior to event will be billed.</li>
                        <li>This is a computer-generated invoice and requires no signature.</li>
                    </ul>
                </div>
            </td>
            <td class="footer-right">
                <table class="totals-table">
                    <tr>
                        <td class="totals-label">Subtotal</td>
                        <td class="totals-value">₹ {{ number_format($quotation->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="totals-label">GST (18%)</td>
                        <td class="totals-value">₹ {{ number_format($quotation->tax, 2) }}</td>
                    </tr>
                    @if($quotation->discount > 0)
                    <tr>
                        <td class="totals-label">Discount</td>
                        <td class="totals-value" style="color: #dc3545;">- ₹ {{ number_format($quotation->discount, 2) }}</td>
                    </tr>
                    @endif
                    <tr class="grand-total-row">
                        <td class="totals-label grand-total-label">Grand Total</td>
                        <td class="totals-value">₹ {{ number_format($quotation->total, 2) }}</td>
                    </tr>
                </table>
                
                <div class="signature-box">
                    <div class="auth-sign">Manam</div>
                    <div class="auth-label">Authorized Signatory</div>
                </div>
            </td>
        </tr>
    </table>

    <div class="page-footer">
        © {{ date('Y') }} Manam Catering Services. All Rights Reserved. • Generated on {{ now()->format('d-m-Y h:i A') }}
    </div>

</body>
</html>
