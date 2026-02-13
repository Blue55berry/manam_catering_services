<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quotation - {{ $quotation->quotation_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #1a4d2e, #2d5016);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .quotation-info {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #2d5016;
        }
        .value {
            color: #666;
        }
        .total {
            background: #2d5016;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 14px;
        }
        .attachment-note {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .attachment-note strong {
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🍽️ Manam Catering Service</h1>
        <p style="margin: 10px 0 0;">Your Quotation is Ready!</p>
    </div>
    
    <div class="content">
        <p>Dear <strong>{{ $quotation->customer_name }}</strong>,</p>
        
        <p>Thank you for your interest in Manam Catering Service! We are pleased to send you the quotation for your upcoming event.</p>
        
        <div class="quotation-info">
            <div class="info-row">
                <span class="label">Quotation Number:</span>
                <span class="value">{{ $quotation->quotation_number }}</span>
            </div>
            <div class="info-row">
                <span class="label">Event Type:</span>
                <span class="value">{{ $quotation->event_type ?? 'General Event' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Event Date:</span>
                <span class="value">{{ $quotation->event_date ? $quotation->event_date->format('F d, Y') : 'TBD' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Guest Count:</span>
                <span class="value">{{ $quotation->guest_count ?? 'TBD' }}</span>
            </div>
        </div>
        
        <div class="total">
            Total Amount: ₹{{ number_format($quotation->total, 2) }}
        </div>
        
        <div class="attachment-note">
            <strong>📎 Quotation PDF Attached</strong><br>
            Please find the detailed quotation document attached to this email as a PDF file. The attachment contains complete itemized pricing and terms & conditions.
        </div>
        
        <p>If you have any questions or would like to discuss the quotation, please feel free to contact us.</p>
        
        <p>We look forward to serving you!</p>
        
        <p style="margin-top: 30px;">
            <strong>Best Regards,</strong><br>
            Manam Catering Service Team<br>
            <span style="color: #666; font-size: 14px;">
                📞 Contact: {{ $quotation->customer_phone }}<br>
                📧 Email: {{ $quotation->customer_email }}
            </span>
        </p>
    </div>
    
    <div class="footer">
        <p>This is an automated email. Please do not reply to this message.</p>
        <p style="font-size: 12px; color: #999;">
            © {{ date('Y') }} Manam Catering Service. All rights reserved.
        </p>
    </div>
</body>
</html>
