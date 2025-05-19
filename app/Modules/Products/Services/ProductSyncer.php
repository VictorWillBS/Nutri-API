<?php

declare(strict_types=1);

namespace App\Modules\Products\Services;

use App\Enums\Products\ProductStatus;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class ProductSyncer
{
    public function __construct() {}

    public function getProductData(string $code): array
    {
        $result = $this->request('get', "$code.json")->json();
        $locked = $this->getLockedKeys();

        if (!isset($result['product'])) {
            return [];
        }

        $product = $result['product'];
        $name = $product['product_name'] ?? $product['product_name_en'] ?? '';

        return [
            'code' => $result['code'],
            'data' => Arr::except($product, $locked),
            'name' => $name,
            'status' => ProductStatus::Published,
            'imported_t' => Carbon::now()->format('Y-m-d H:i:s'),
        ];
    }

    protected function request(string $method, string $endpoint, ?array $data = [])
    {
        $url = config('services.openfoodfacts.endpoint') . 'product/' . $endpoint;

        return Http::$method($url, $data);
    }

    private function getLockedKeys(): array
    {
        return [
            "ecoscore_data",
            "ecoscore_grade",
            "ecoscore_score",
            "environment_impact_level_tags",
            "image_packaging_url",
            "image_packaging_small_url",
            "informers_tags",
            "ingredients_analysis_tags",
            "ingredients_from_or_that_may_be_from_palm_oil_n",
            "ingredients_from_or_that_may_be_from_palm_oil_tags",
            "ingredients_text_with_allergens",
            "interface_version_created",
            "interface_version_modified",
            "known_ingredients_n",
            "labels_lc",
            "labels_prev_hierarchy",
            "lang",
            "last_image_t",
            "last_modified_by",
            "nutrient_levels",
            "nutriments",
            "nutriscore_data",
            "product_name"
        ];
    }
}
