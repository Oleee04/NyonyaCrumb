<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');  // ← PERBAIKI INI! BUKAN emails.contact
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:100',
            'email' => 'required|email|max:100',
            'subject' => 'nullable|max:200',
            'message' => 'required|min:10|max:5000',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject ?? 'Tidak ada subjek',
            'message' => $request->message,
        ];

        try {
            Mail::to('rzrakbar345@gmail.com')->send(new ContactMail($data));
            return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim! Kami akan merespon dalam 1x24 jam.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim pesan: ' . $e->getMessage());
        }
    }
}