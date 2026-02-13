<?php

namespace App\Exports;

use App\Models\MenuItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MenuItemsExport implements FromCollection, WithHeadings, WithMapping
{
    private $row = 0;

    public function collection()
    {
        return MenuItem::with('category')->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'S.No',
            'Created Date',
            'Food Name',
            'Category',
            'Price',
            'Type',
            'Description',
        ];
    }

    public function map($item): array
    {
        return [
            ++$this->row,
            $item->created_at ? $item->created_at->format('d M Y') : 'N/A',
            $item->name,
            $item->category->name ?? 'Uncategorized',
            $item->price,
            $item->type ? ucfirst($item->type) : 'Veg',
            $item->description,
        ];
    }
}
