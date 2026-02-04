<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductImageService
{
    /**
     * Upload multiple images for a product.
     *
     * @param Product $product
     * @param array $images
     * @return array
     */
    public function uploadImages(Product $product, array $images): array
    {
        $uploadedImages = [];
        $isFirstImage = $product->images()->count() === 0;

        foreach ($images as $index => $image) {
            $path = $image->store('products', 'public');
            
            $productImage = ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'alt_text' => $product->name . ' - Image ' . ($index + 1),
                'is_primary' => $isFirstImage && $index === 0,
                'sort_order' => $product->images()->count() + $index
            ]);

            $uploadedImages[] = $productImage;
        }

        return $uploadedImages;
    }

    /**
     * Set image as primary.
     *
     * @param ProductImage $image
     * @return ProductImage
     */
    public function setPrimaryImage(ProductImage $image): ProductImage
    {
        // Remove primary status from other images
        ProductImage::where('product_id', $image->product_id)
            ->where('id', '!=', $image->id)
            ->update(['is_primary' => false]);

        // Set this image as primary
        $image->update(['is_primary' => true]);

        return $image->fresh();
    }

    /**
     * Delete image from storage and database.
     *
     * @param ProductImage $image
     * @return bool
     */
    public function deleteImage(ProductImage $image): bool
    {
        // Delete from storage
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        // If this was primary image, set another as primary
        if ($image->is_primary) {
            $nextImage = ProductImage::where('product_id', $image->product_id)
                ->where('id', '!=', $image->id)
                ->orderBy('sort_order')
                ->first();

            if ($nextImage) {
                $nextImage->update(['is_primary' => true]);
            }
        }

        // Delete from database
        return $image->delete();
    }

    /**
     * Reorder images.
     *
     * @param Product $product
     * @param array $imageIds
     * @return bool
     */
    public function reorderImages(Product $product, array $imageIds): bool
    {
        foreach ($imageIds as $index => $imageId) {
            ProductImage::where('product_id', $product->id)
                ->where('id', $imageId)
                ->update(['sort_order' => $index]);
        }

        return true;
    }
}