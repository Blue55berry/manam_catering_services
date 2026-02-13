<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Menu Items List</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        #content-to-pdf { width: 100%; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; color: #333; }
        .header { margin-bottom: 20px; text-align: center; }
    </style>
    <script>
        window.onload = function() {
            const element = document.getElementById('content-to-pdf');
            const opt = {
                margin:       0.5,
                filename:     'menu-items.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            
            // Generate and download
            html2pdf().set(opt).from(element).save().then(function() {
                // Close window after a short delay to ensure download starts
                setTimeout(function() {
                    window.close();
                }, 1000); 
            });
        }
    </script>
</head>
<body>
    <div id="content-to-pdf">
        <div class="header">
        <h1>Menu Items List</h1>
        <p>Generated on: {{ date('d M Y, h:i A') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>Created Date</th>
                <th>Food Name</th>
                <th>Category</th>
                <th>Type</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($menuItems as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->created_at ? $item->created_at->format('d M Y') : 'N/A' }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->category->name ?? 'Uncategorized' }}</td>
                <td>{{ $item->type ? ucfirst($item->type) : 'Veg' }}</td>
                <td>{{ $item->price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</body>
</html>
