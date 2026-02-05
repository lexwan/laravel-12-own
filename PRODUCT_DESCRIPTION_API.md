# Product API Documentation - Description Field Update

## Overview
Field `description` telah ditambahkan ke model Product untuk memberikan deskripsi detail produk. Field ini bersifat opsional (nullable) dan bertipe text.

## Database Changes
- **Migration**: `2026_02_05_065900_add_description_to_products_table.php`
- **Field Type**: `text`, nullable
- **Position**: Setelah field `name`

## API Endpoints yang Terpengaruh

### 1. GET /api/products
**Response Format:**
```json
{
  "success": true,
  "message": "Products retrieved successfully",
  "data": [
    {
      "id": 1,
      "name": "iPhone 15 Pro",
      "description": "Latest iPhone with A17 Pro chip, titanium design, and advanced camera system. Features 6.1-inch Super Retina XDR display.",
      "sku": "IPH15PRO001",
      "price": 999.99,
      "formatted_price": "$999.99",
      "stock": 50,
      "category": {
        "id": 1,
        "name": "Electronics",
        "description": "Electronic devices and gadgets"
      },
      "images": null,
      "image_urls": [],
      "created_at": "2026-02-05T06:59:00.000Z",
      "updated_at": "2026-02-05T06:59:00.000Z"
    }
  ]
}
```

### 2. GET /api/products/{id}
**Response Format:**
```json
{
  "success": true,
  "message": "Product retrieved successfully",
  "data": {
    "id": 1,
    "name": "iPhone 15 Pro",
    "description": "Latest iPhone with A17 Pro chip, titanium design, and advanced camera system. Features 6.1-inch Super Retina XDR display.",
    "sku": "IPH15PRO001",
    "price": 999.99,
    "formatted_price": "$999.99",
    "stock": 50,
    "category": {
      "id": 1,
      "name": "Electronics",
      "description": "Electronic devices and gadgets"
    },
    "images": null,
    "image_urls": [],
    "created_at": "2026-02-05T06:59:00.000Z",
    "updated_at": "2026-02-05T06:59:00.000Z"
  }
}
```

### 3. POST /api/products
**Request Body:**
```json
{
  "name": "Product Name",
  "description": "Optional product description", // BARU - Opsional
  "sku": "PROD001",
  "price": 99.99,
  "stock": 100,
  "category_id": 1,
  "images": [] // Optional file uploads
}
```

**Validation Rules:**
- `description`: `nullable|string`

### 4. PATCH /api/products/{id}
**Request Body:**
```json
{
  "name": "Updated Product Name", // Optional
  "description": "Updated product description", // BARU - Opsional
  "sku": "PROD001", // Optional
  "price": 99.99, // Optional
  "stock": 100, // Optional
  "category_id": 1, // Optional
  "images": [] // Optional file uploads
}
```

**Validation Rules:**
- `description`: `sometimes|nullable|string`

### 5. DELETE /api/products/{id}
Tidak ada perubahan pada endpoint ini.

## Search Functionality Update

### GET /api/search
Field `description` sekarang juga dicari ketika menggunakan parameter `q`:

**Request:**
```
GET /api/search?q=iPhone
```

**Behavior:**
- Mencari di field `name`, `sku`, dan `description`
- Menggunakan LIKE query dengan wildcard

### GET /api/search/suggestions
Field `description` juga digunakan dalam pencarian suggestions.

## Model Changes

### Product Model
```php
protected $fillable = [
    'name',
    'description', // BARU
    'sku',
    'price',
    'stock',
    'category_id',
    'images',
];
```

## Sample Data
ProductSeeder telah dibuat dengan data sample yang mencakup field description:

```php
[
    'name' => 'iPhone 15 Pro',
    'description' => 'Latest iPhone with A17 Pro chip, titanium design, and advanced camera system. Features 6.1-inch Super Retina XDR display.',
    'sku' => 'IPH15PRO001',
    'price' => 999.99,
    'stock' => 50,
    'category_id' => 1,
]
```

## Migration Commands
```bash
# Menjalankan migration
php artisan migrate

# Menjalankan seeder (opsional)
php artisan db:seed --class=ProductSeeder
```

## Backward Compatibility
- Field `description` bersifat nullable, sehingga tidak akan mempengaruhi data existing
- API endpoints tetap berfungsi normal tanpa field description
- Response akan menampilkan `"description": null` untuk produk yang belum memiliki deskripsi