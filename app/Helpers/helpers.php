<?php

if (!function_exists('formatRupiah')) {
    function formatRupiah($price)
    {
        if (!$price && $price !== 0) return 'Rp 0';
        return 'Rp ' . number_format($price, 0, ',', '.');
    }
}

if (!function_exists('generateStarRating')) {
    function generateStarRating($rating)
    {
        $rating = floatval($rating);
        $fullStars = floor($rating);
        $hasHalfStar = ($rating - $fullStars) >= 0.5;
        $emptyStars = 5 - ceil($rating);
        
        $stars = '';
        
        // Full stars
        for ($i = 0; $i < $fullStars; $i++) {
            $stars .= '<i class="fas fa-star" style="color: #ffc107;"></i>';
        }
        
        // Half star
        if ($hasHalfStar) {
            $stars .= '<i class="fas fa-star-half-alt" style="color: #ffc107;"></i>';
        }
        
        // Empty stars
        for ($i = 0; $i < $emptyStars; $i++) {
            $stars .= '<i class="far fa-star" style="color: #ffc107;"></i>';
        }
        
        return $stars;
    }
}

if (!function_exists('getStockStatus')) {
    function getStockStatus($stock)
    {
        if ($stock <= 0) return 'Habis';
        if ($stock <= 5) return 'Hampir Habis';
        return 'Tersedia';
    }
}