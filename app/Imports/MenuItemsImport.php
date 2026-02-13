<?php

namespace App\Imports;

use App\Models\MenuCategory;
use App\Models\MenuItem;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MenuItemsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Ensure required fields are present and not empty
        // Handle "Price" or "Price (INR)" (slugified to price_inr)
        $price = $row['price'] ?? $row['price_inr'] ?? null;

        if (empty($row['category']) || empty($row['name']) || $price === null) {
            return null;
        }

        // Clean price: remove currency symbols and commas
        $priceRaw = (string) $price;
        $priceClean = preg_replace('/[^0-9.]/', '', $priceRaw);

        if (!is_numeric($priceClean)) {
            return null;  // Skip if price is not valid
        }

        // Find or create category
        $categoryName = trim($row['category']);
        $category = MenuCategory::firstOrCreate(
            ['name' => $categoryName],
            ['slug' => Str::slug($categoryName), 'is_active' => true, 'order' => 0]
        );

        return new MenuItem([
            'category_id' => $category->id,
            'name' => trim($row['name']),
            'price' => (float) $priceClean,
            'description' => $row['description'] ?? null,
            'type' => 'veg',
            'is_active' => true,
            'is_imported' => false,
            'order' => 0,
        ]);
    }

    public function rules(): array
    {
        return [
            'category' => 'required|string',
            'name' => 'required|string',
            'price' => 'required_without:price_inr',
            'price_inr' => 'required_without:price',
            'description' => 'nullable|string',
        ];
    }
}
