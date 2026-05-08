<?php
// fix-key.php - Simpan di root project

echo "========================================\n";
echo "  FIXING APP_KEY FOR LARAVEL\n";
echo "========================================\n\n";

// Generate random 32 bytes and encode to base64
$randomBytes = random_bytes(32);
$key = 'base64:' . base64_encode($randomBytes);

echo "New APP_KEY: " . $key . "\n\n";

// Path to .env file
$envPath = __DIR__ . '/.env';

if (!file_exists($envPath)) {
    echo "ERROR: .env file not found!\n";
    exit(1);
}

// Read .env file
$envContent = file_get_contents($envPath);

// Update or add APP_KEY
if (preg_match('/^APP_KEY=.*$/m', $envContent)) {
    $envContent = preg_replace('/^APP_KEY=.*$/m', 'APP_KEY=' . $key, $envContent);
    echo "✓ Updated existing APP_KEY in .env\n";
} else {
    $envContent .= "\nAPP_KEY=" . $key . "\n";
    echo "✓ Added new APP_KEY to .env\n";
}

// Save .env file
file_put_contents($envPath, $envContent);

echo "\n✓ .env file has been updated!\n";
echo "\nNow run: php artisan config:clear\n";
echo "Then run: php artisan serve\n";