<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            [
                'reviewer_name' => 'Rehan Wallani',
                'reviewer_title' => null,
                'review_text' => 'Professional and efficient installation with careful attention to detail. The finished flooring gave the apartment a completely refreshed look.',
                'rating' => 5.0,
                'sort_order' => 1,
                'status' => true,
            ],
            [
                'reviewer_name' => 'Meagan van Renen',
                'reviewer_title' => null,
                'review_text' => 'The team was flexible with scheduling during renovation delays, and the completed flooring looked excellent.',
                'rating' => 5.0,
                'sort_order' => 2,
                'status' => true,
            ],
            [
                'reviewer_name' => 'Aniket Santosh',
                'reviewer_title' => null,
                'review_text' => 'Good value, strong flooring quality, and an organized team that responded quickly throughout the work.',
                'rating' => 5.0,
                'sort_order' => 3,
                'status' => true,
            ],
            [
                'reviewer_name' => 'Gabija',
                'reviewer_title' => null,
                'review_text' => 'Helpful follow-up, professional support, and very good flooring quality made the overall experience smooth and efficient.',
                'rating' => 5.0,
                'sort_order' => 4,
                'status' => true,
            ],
            [
                'reviewer_name' => 'Silvia Moraes',
                'reviewer_title' => null,
                'review_text' => 'Efficient and professional service with fair pricing, good product quality, and responsive customer support.',
                'rating' => 5.0,
                'sort_order' => 5,
                'status' => true,
            ],
        ];

        foreach ($reviews as $item) {
            $review = Review::withTrashed()
                ->where('reviewer_name', $item['reviewer_name'])
                ->first();

            if (! $review) {
                Review::create($item);
                continue;
            }

            if ($review->trashed()) {
                $review->restore();
            }

            $review->update($item);
        }
    }
}
