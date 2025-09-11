<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        // Ambil data cart dari request (sementara sederhana)
        $products = $request->products; // array [id => qty]

        $total = 0;
        foreach ($products as $product) {
            $total += $product['price'] * $product['quantity'];
        }

        // Simpan order di DB
        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'total_amount' => $total,
        ]);

        foreach ($products as $product) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]);
        }

        // Buat invoice ke Xendit
        $response = Http::withBasicAuth(config('services.xendit.api_key'), '')
            ->post('https://api.xendit.co/v2/invoices', [
                'external_id' => 'order-' . $order->id,
                'amount' => $order->total_amount,
                'payer_email' => Auth::user()->email,
                'description' => 'Pembayaran Order #' . $order->id,
            ]);

        $invoice = $response->json();

        // Update order dengan invoice
        $order->update([
            'xendit_invoice_id' => $invoice['id'],
            'xendit_invoice_url' => $invoice['invoice_url'],
        ]);

        // Redirect user ke halaman pembayaran
        return redirect($invoice['invoice_url']);
    }

    // Callback dari Xendit
    public function callback(Request $request)
    {
        $data = $request->all();

        $order = Order::where('xendit_invoice_id', $data['id'])->first();

        if ($order) {
            $order->update(['status' => strtolower($data['status'])]);
        }

        return response()->json(['success' => true]);
    }
}
