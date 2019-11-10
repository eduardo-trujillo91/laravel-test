<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class ProductsPending extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Productos con más de una semana en pendientes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fecha7 = date('Y-m-d', strtotime(date('Y-m-d') . ' + 7 days'));
        $products_pending = DB::table('products')
            ->whereNull('deleted_at')
            ->where('updated_at', '<', $fecha7)
            ->get();
        foreach ($products_pending as $item) {
            foreach (User::all() as $user) {
                $details = [
                    'greeting' => 'Producto pendiente',
                    'body' => 'Produto con más de una semana en pendiente ' . $item->name,
                    'actionText' => 'Ir a',
                    'actionURL' => url('127.0.0.1:8000/api/products/' . $item->id),
                    'back' => 'ISSN ' . $item->issn
                ];
                Notification::send($user, new \App\Notifications\ProductsPending($details));
            }
        }
    }
}
