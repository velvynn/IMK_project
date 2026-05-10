<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\OrderController;

class AutoCancelExpiredOrders extends Command
{
    protected $signature = 'orders:auto-cancel';
    protected $description = 'Auto cancel expired orders (24 hours unpaid)';

    public function handle()
    {
        $controller = new OrderController();
        $cancelled = $controller->autoCancelExpiredOrders();
        
        $this->info("Auto-cancelled {$cancelled} expired orders.");
    }
}