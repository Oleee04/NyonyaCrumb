<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $hasPurchased = false;
        if (Auth::check() && Auth::user()->customer) {
            $hasPurchased = \App\Models\Order::where('customer_id', Auth::user()->customer->id)
                ->whereIn('status', ['Selesai', 'Paid', 'Kirim'])
                ->whereHas('orderItems', function ($query) use ($id) {
                    $query->where('produk_id', $id);
                })->exists();
        }

        if (!$hasPurchased) {
            return redirect()->back()->with('error', 'Anda harus membeli produk ini terlebih dahulu sebelum dapat memberikan ulasan.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'produk_id' => $id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }
}
