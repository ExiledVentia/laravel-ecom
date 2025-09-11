<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{

    public function processCheckout(Request $request)
    {
        $request->validate([
            'product_id =>required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Not enough product in stock');
        }

        $totalAmount = $product->price * $request->quantity;
        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'total_amount' => $totalAmount,
        ]);

        $order->items()->create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->price,
        ]);

        $product->decrement('stock', $request->quantity);

        $payload = [
            'external_id' => 'order-' . $order->id . '-' . Str::random(6),
            'payer_email' => Auth::user()->email,
            'description' => 'Pembayaran untuk Order #' . $order->id,
            'amount' => $totalAmount,
        ];

        $secretKey = env('XENDIT_SECRET_KEYS');

        $response = Http::withBasicAuth($secretKey, '')
            ->post('https://api.xendit.co/v2/invoices', $payload);

        if ($response->successful()) {
            $xenditInvoice = $response->json();

            $order->xendit_invoice_id = $xenditInvoice['id'];
            $order->save();

            return redirect($xenditInvoice['invoice_url']);
        } else {
            
            return back()->with('error', 'Gagal membuat invoice pembayaran. Silakan coba lagi.');
        }
    }

}
