<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     */
    public function index()
    {
        $orders = auth()->user()->orders()
            ->with(['orderItems.product', 'shippingAddress'])
            ->where('status', '!=', OrderStatusEnum::Draft->value) // Exclude draft orders
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Orders/Index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Display the specified order details.
     */
    public function show(Order $order)
    {
        // Ensure the user can only view their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load([
            'orderItems.product',
            'orderItems.variationOptions.variation_type',
            'shippingAddress.country'
        ]);

        return Inertia::render('Orders/Show', [
            'order' => $order,
        ]);
    }

    /**
     * Generate and display an invoice for the order.
     */
    public function invoice(Order $order)
    {
        // Ensure the user can only view invoices for their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Load relationships
        $order->load([
            'user',
            'orderItems.product',
            'orderItems.variationOptions.variation_type',
            'shippingAddress.country'
        ]);

        // Calculate subtotal
        $subtotal = 0;
        foreach ($order->orderItems as $item) {
            $subtotal += $item->price * $item->quantity;
        }
        $order->subtotal = $subtotal;

        // Generate invoice and return view
        return view('orders.invoice', compact('order'));
    }
}
