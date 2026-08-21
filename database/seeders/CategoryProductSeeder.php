<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            $categories = $this->seedCategories();
            $this->seedProducts($categories);
        });
    }

    /**
     * Seed the four public catalog categories used by the reference website.
     *
     * @return array<string, \App\Models\Category>
     */
    private function seedCategories(): array
    {
        $items = [
            [
                'name' => 'Aluminium Profiles',
                'slug' => 'aluminium-profiles',
                'description' => 'Premium aluminium finishing profiles for flooring and wall applications.',
                'sort_order' => 1,
                'status' => true,
            ],
            [
                'name' => 'Flooring',
                'slug' => 'flooring',
                'description' => 'Premium flooring collections including SPC vinyl styles for residential and commercial interiors.',
                'sort_order' => 2,
                'status' => true,
            ],
            [
                'name' => 'Skirting',
                'slug' => 'skirting',
                'description' => 'Skirting and covering profiles designed to create a clean finish around flooring edges.',
                'sort_order' => 3,
                'status' => true,
            ],
            [
                'name' => 'WPC Decking',
                'slug' => 'wpc-decking',
                'description' => 'Wood-plastic composite decking products for outdoor surface applications.',
                'sort_order' => 4,
                'status' => true,
            ],
        ];

        $categories = [];

        foreach ($items as $item) {
            $category = Category::withTrashed()
                ->where('slug', $item['slug'])
                ->first();

            if (! $category) {
                $category = new Category();
            } elseif ($category->trashed()) {
                $category->restore();
            }

            $category->forceFill($item)->save();

            $categories[$item['slug']] = $category;
        }

        return $categories;
    }

    /**
     * Seed catalog products related to the reference website.
     *
     * Reference-site images are intentionally NOT copied into the seeder.
     * Upload client-owned featured/gallery images from the Admin panel.
     *
     * @param array<string, \App\Models\Category> $categories
     */
    private function seedProducts(array $categories): void
    {
        $flooringSpecifications = [
            'Description' => 'SPC Flooring',
            'Plank Size' => '180×1220×4mm + 1mm PAD / 127×635×4mm + 1mm PAD',
            'Wear Layer' => '0.3mm (12mil)',
            'Surface' => 'Light embossed',
            'Gloss Level' => '5–7',
            'Click' => 'Unilin Angle-Angle',
            'Edge' => 'Micro-bevel',
        ];

        $flooringDescription = 'A durable SPC flooring collection with a realistic surface finish, integrated underlay and click-lock installation, suitable for residential and light commercial spaces.';

        $products = [
            /*
            |--------------------------------------------------------------------------
            | Flooring
            |--------------------------------------------------------------------------
            */
            [
                'category' => 'flooring',
                'name' => 'Royal Oak',
                'slug' => 'royal-oak',
                'sku' => 'FE-FLR-001',
                'short_description' => 'Royal Oak SPC flooring finish.',
                'description' => $flooringDescription,
                'specifications' => $flooringSpecifications,
                'is_featured' => false,
                'sort_order' => 1,
            ],
            [
                'category' => 'flooring',
                'name' => 'Oak Ivory',
                'slug' => 'oak-ivory',
                'sku' => 'FE-FLR-002',
                'short_description' => 'Oak Ivory SPC flooring finish.',
                'description' => $flooringDescription,
                'specifications' => $flooringSpecifications,
                'is_featured' => false,
                'sort_order' => 2,
            ],
            [
                'category' => 'flooring',
                'name' => 'Honey Oak',
                'slug' => 'honey-oak',
                'sku' => 'FE-FLR-003',
                'short_description' => 'Honey Oak SPC flooring finish.',
                'description' => $flooringDescription,
                'specifications' => $flooringSpecifications,
                'is_featured' => false,
                'sort_order' => 3,
            ],
            [
                'category' => 'flooring',
                'name' => 'Ash Grey 2007',
                'slug' => 'ash-grey-2007',
                'sku' => 'FE-FLR-004',
                'short_description' => 'Ash Grey 2007 SPC flooring finish.',
                'description' => $flooringDescription,
                'specifications' => $flooringSpecifications,
                'is_featured' => false,
                'sort_order' => 4,
            ],
            [
                'category' => 'flooring',
                'name' => 'Summer Oak',
                'slug' => 'summer-oak',
                'sku' => 'FE-FLR-005',
                'short_description' => 'Summer Oak SPC flooring finish.',
                'description' => $flooringDescription,
                'specifications' => $flooringSpecifications,
                'is_featured' => false,
                'sort_order' => 5,
            ],
            [
                'category' => 'flooring',
                'name' => 'Butter Nut',
                'slug' => 'butter-nut',
                'sku' => 'FE-FLR-006',
                'short_description' => 'Butter Nut SPC flooring finish.',
                'description' => $flooringDescription,
                'specifications' => $flooringSpecifications,
                'is_featured' => true,
                'sort_order' => 6,
            ],
            [
                'category' => 'flooring',
                'name' => 'Vanila Grey Brown',
                'slug' => 'vanila-grey-brown',
                'sku' => 'FE-FLR-007',
                'short_description' => 'Vanila Grey Brown SPC flooring finish.',
                'description' => $flooringDescription,
                'specifications' => $flooringSpecifications,
                'is_featured' => false,
                'sort_order' => 7,
            ],
            [
                'category' => 'flooring',
                'name' => 'Pearl Grey',
                'slug' => 'pearl-grey',
                'sku' => 'FE-FLR-008',
                'short_description' => 'Pearl Grey SPC flooring finish.',
                'description' => $flooringDescription,
                'specifications' => $flooringSpecifications,
                'is_featured' => true,
                'sort_order' => 8,
            ],
            [
                'category' => 'flooring',
                'name' => 'Walnut Brown',
                'slug' => 'walnut-brown',
                'sku' => 'FE-FLR-009',
                'short_description' => 'Walnut Brown SPC flooring finish.',
                'description' => $flooringDescription,
                'specifications' => $flooringSpecifications,
                'is_featured' => true,
                'sort_order' => 9,
            ],
            [
                'category' => 'flooring',
                'name' => 'Wenge',
                'slug' => 'wenge',
                'sku' => 'FE-FLR-010',
                'short_description' => 'Wenge SPC flooring finish.',
                'description' => $flooringDescription,
                'specifications' => $flooringSpecifications,
                'is_featured' => false,
                'sort_order' => 10,
            ],
            [
                'category' => 'flooring',
                'name' => 'White Oak',
                'slug' => 'white-oak',
                'sku' => 'FE-FLR-011',
                'short_description' => 'White Oak SPC flooring finish.',
                'description' => $flooringDescription,
                'specifications' => $flooringSpecifications,
                'is_featured' => false,
                'sort_order' => 11,
            ],
            [
                'category' => 'flooring',
                'name' => 'Forest Oak',
                'slug' => 'forest-oak',
                'sku' => 'FE-FLR-012',
                'short_description' => 'Forest Oak SPC flooring finish.',
                'description' => $flooringDescription,
                'specifications' => $flooringSpecifications,
                'is_featured' => true,
                'sort_order' => 12,
            ],
            [
                'category' => 'flooring',
                'name' => 'Ancient Grey',
                'slug' => 'ancient-grey',
                'sku' => 'FE-FLR-013',
                'short_description' => 'Ancient Grey SPC flooring finish.',
                'description' => $flooringDescription,
                'specifications' => $flooringSpecifications,
                'is_featured' => false,
                'sort_order' => 13,
            ],
            [
                'category' => 'flooring',
                'name' => 'Antique',
                'slug' => 'antique',
                'sku' => 'FE-FLR-014',
                'short_description' => 'Antique SPC flooring finish.',
                'description' => $flooringDescription,
                'specifications' => $flooringSpecifications,
                'is_featured' => false,
                'sort_order' => 14,
            ],
            [
                'category' => 'flooring',
                'name' => 'Light Oak',
                'slug' => 'light-oak',
                'sku' => 'FE-FLR-015',
                'short_description' => 'Light Oak SPC flooring finish.',
                'description' => $flooringDescription,
                'specifications' => $flooringSpecifications,
                'is_featured' => false,
                'sort_order' => 15,
            ],
            [
                'category' => 'flooring',
                'name' => 'Warm Teak',
                'slug' => 'warm-teak',
                'sku' => 'FE-FLR-016',
                'short_description' => 'Warm Teak SPC flooring finish.',
                'description' => $flooringDescription,
                'specifications' => $flooringSpecifications,
                'is_featured' => true,
                'sort_order' => 16,
            ],
            [
                'category' => 'flooring',
                'name' => 'Vintage',
                'slug' => 'vintage',
                'sku' => 'FE-FLR-017',
                'short_description' => 'Vintage SPC flooring finish.',
                'description' => $flooringDescription,
                'specifications' => $flooringSpecifications,
                'is_featured' => false,
                'sort_order' => 17,
            ],
            [
                'category' => 'flooring',
                'name' => 'Walnut Heirngbone',
                'slug' => 'walnut-heirngbone',
                'sku' => 'FE-FLR-018',
                'short_description' => 'Walnut Heirngbone flooring finish.',
                'description' => $flooringDescription,
                'specifications' => $flooringSpecifications,
                'is_featured' => false,
                'sort_order' => 18,
            ],

            /*
            |--------------------------------------------------------------------------
            | WPC Decking
            |--------------------------------------------------------------------------
            */
            [
                'category' => 'wpc-decking',
                'name' => 'WPC 3',
                'slug' => 'wpc-3',
                'sku' => 'FE-WPC-003',
                'short_description' => 'WPC decking style 3.',
                'description' => 'A WPC decking option for durable outdoor surface applications.',
                'specifications' => [
                    'Product Type' => 'WPC Decking',
                    'Application' => 'Outdoor Decking',
                ],
                'is_featured' => false,
                'sort_order' => 1,
            ],
            [
                'category' => 'wpc-decking',
                'name' => 'WPC 4',
                'slug' => 'wpc-4',
                'sku' => 'FE-WPC-004',
                'short_description' => 'WPC decking style 4.',
                'description' => 'A WPC decking option for durable outdoor surface applications.',
                'specifications' => [
                    'Product Type' => 'WPC Decking',
                    'Application' => 'Outdoor Decking',
                ],
                'is_featured' => false,
                'sort_order' => 2,
            ],
            [
                'category' => 'wpc-decking',
                'name' => 'WPC 5',
                'slug' => 'wpc-5',
                'sku' => 'FE-WPC-005',
                'short_description' => 'WPC decking style 5.',
                'description' => 'A WPC decking option for durable outdoor surface applications.',
                'specifications' => [
                    'Product Type' => 'WPC Decking',
                    'Application' => 'Outdoor Decking',
                ],
                'is_featured' => false,
                'sort_order' => 3,
            ],
            [
                'category' => 'wpc-decking',
                'name' => 'WPC 6',
                'slug' => 'wpc-6',
                'sku' => 'FE-WPC-006',
                'short_description' => 'WPC decking style 6.',
                'description' => 'A WPC decking option for durable outdoor surface applications.',
                'specifications' => [
                    'Product Type' => 'WPC Decking',
                    'Application' => 'Outdoor Decking',
                ],
                'is_featured' => false,
                'sort_order' => 4,
            ],
            [
                'category' => 'wpc-decking',
                'name' => 'WPC 10',
                'slug' => 'wpc-10',
                'sku' => 'FE-WPC-010',
                'short_description' => 'WPC decking style 10.',
                'description' => 'A WPC decking option for durable outdoor surface applications.',
                'specifications' => [
                    'Product Type' => 'WPC Decking',
                    'Application' => 'Outdoor Decking',
                ],
                'is_featured' => false,
                'sort_order' => 5,
            ],
            [
                'category' => 'wpc-decking',
                'name' => 'WPC 12',
                'slug' => 'wpc-12',
                'sku' => 'FE-WPC-012',
                'short_description' => 'WPC decking style 12.',
                'description' => 'A WPC decking option for durable outdoor surface applications.',
                'specifications' => [
                    'Product Type' => 'WPC Decking',
                    'Application' => 'Outdoor Decking',
                ],
                'is_featured' => false,
                'sort_order' => 6,
            ],
            [
                'category' => 'wpc-decking',
                'name' => 'WPC 13',
                'slug' => 'wpc-13',
                'sku' => 'FE-WPC-013',
                'short_description' => 'WPC decking style 13.',
                'description' => 'A WPC decking option for durable outdoor surface applications.',
                'specifications' => [
                    'Product Type' => 'WPC Decking',
                    'Application' => 'Outdoor Decking',
                ],
                'is_featured' => false,
                'sort_order' => 7,
            ],
            [
                'category' => 'wpc-decking',
                'name' => 'WPC 15',
                'slug' => 'wpc-15',
                'sku' => 'FE-WPC-015',
                'short_description' => 'WPC decking style 15.',
                'description' => 'A WPC decking option for durable outdoor surface applications.',
                'specifications' => [
                    'Product Type' => 'WPC Decking',
                    'Application' => 'Outdoor Decking',
                ],
                'is_featured' => false,
                'sort_order' => 8,
            ],

            /*
            |--------------------------------------------------------------------------
            | Aluminium Profiles
            |--------------------------------------------------------------------------
            */
            [
                'category' => 'aluminium-profiles',
                'name' => 'Aluminium Profiles',
                'slug' => 'aluminium-profiles',
                'sku' => 'FE-ALU-001',
                'short_description' => 'Premium aluminium finishing profiles for flooring and wall applications.',
                'description' => 'A premium collection of aluminium Joint, L-Corner and Ending profiles in multiple decorative finishes, designed for clean and durable flooring or wall edges.',
                'specifications' => [
                    'Profile Types' => 'Joint, L-Corner, Ending',
                    'Finishes' => 'Matte Black, Spray White, Dull Gold, Polished Rose Gold, Matte Silver',
                    'Application' => 'Flooring and Wall Finishing',
                ],
                'is_featured' => false,
                'sort_order' => 1,
            ],

            /*
            |--------------------------------------------------------------------------
            | Skirting
            |--------------------------------------------------------------------------
            */
            [
                'category' => 'skirting',
                'name' => 'Covering Skirtings',
                'slug' => 'covering-skirtings',
                'sku' => 'FE-SKT-001',
                'short_description' => 'Covering skirting solution for neat flooring edge finishes.',
                'description' => 'A skirting profile intended to provide a neat transition and finished appearance around flooring edges.',
                'specifications' => [
                    'Product Type' => 'Covering Skirting',
                    'Application' => 'Floor Edge Finishing',
                ],
                'is_featured' => false,
                'sort_order' => 1,
            ],
            [
                'category' => 'skirting',
                'name' => 'Skirtings',
                'slug' => 'skirtings',
                'sku' => 'FE-SKT-002',
                'short_description' => 'Skirting profile for clean and coordinated floor finishing.',
                'description' => 'A practical skirting solution for finishing flooring edges and coordinating interior floor transitions.',
                'specifications' => [
                    'Product Type' => 'Skirting',
                    'Application' => 'Floor Edge Finishing',
                ],
                'is_featured' => false,
                'sort_order' => 2,
            ],
        ];

        foreach ($products as $item) {
            $categorySlug = $item['category'];

            if (! isset($categories[$categorySlug])) {
                continue;
            }

            unset($item['category']);

            $item['category_id'] = $categories[$categorySlug]->id;
            $item['status'] = true;

            $product = Product::withTrashed()
                ->where('slug', $item['slug'])
                ->first();

            if (! $product) {
                $product = new Product();
            } elseif ($product->trashed()) {
                $product->restore();
            }

            $product->forceFill($item)->save();
        }
    }
}
