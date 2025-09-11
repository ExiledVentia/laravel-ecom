<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar order milik user yang sedang login.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail order tertentu milik user.
     */
    public function show($id)
    {
        $order = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    /**
     * Form checkout (pilih produk & jumlah).
     */
    public function createCheckout()
    {
        $products = Product::all();
        return view('orders.checkout', compact('products'));
    }

    /**
     * Proses checkout → simpan order & buat invoice ke Xendit.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $total   = $product->price * $request->quantity;

        // Simpan order dengan status awal PENDING
        $order = Order::create([
            'user_id'      => Auth::id(),
            'total_amount' => $total,
            'status'       => 'PENDING',
        ]);

        // Simpan item ke order_items
        OrderItem::create([
            'order_id'   => $order->id,
            'product_id' => $product->id,
            'quantity'   => $request->quantity,
            'price'      => $product->price,
        ]);

        // Buat invoice di Xendit
        $response = Http::withBasicAuth(env('XENDIT_SECRET_KEY'), '')
            ->post('https://api.xendit.co/v2/invoices', [
                'external_id' => 'order-' . $order->id,
                'amount'      => $total,
                'payer_email' => Auth::user()->email,
                'description' => "Pembayaran order #{$order->id}"
            ]);

        if ($response->failed()) {
            return back()->with('error', 'Gagal membuat invoice.');
        }

        $invoice = $response->json();

        // Simpan invoice ID + URL dari Xendit
        $order->update([
            'xendit_invoice_id'  => $invoice['id'],
            'xendit_invoice_url' => $invoice['invoice_url'],
        ]);

        // Redirect user ke halaman pembayaran Xendit
        return redirect($invoice['invoice_url']);
    }

    /**
     * Callback webhook dari Xendit.
     */
    public function callback(Request $request)
    {
        $data = $request->all();

        $orderId = str_replace('order-', '', $data['external_id'] ?? '');
        $order   = Order::find($orderId);

        if ($order) {
            $order->update([
                'status' => $data['status'] ?? 'PENDING'
            ]);
        }

        return response()->json(['success' => true]);
    }
}
