<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
// Catatan: Pastikan kamu sudah menginstall HTTP Client (Guzzle) atau package spreadsheet-mu jika dibutuhkan nanti

class CheckoutController extends Controller
{
    // Fungsi bawaan untuk set konfigurasi Midtrans otomatis di semua fungsi
    public function __construct()
    {
        Config::$serverKey = 'Mid-server-hxZ3a9jJfeCAKqyMUY8MKR7p';
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function getToken(Request $request)
    {
        // Parameter transaksi (Data dari Frontend)
        $params = [
            'transaction_details' => [
                'order_id' => 'JS-RENT-' . uniqid(), 
                'gross_amount' => (int) $request->price, 
            ],
            'customer_details' => [
                'first_name' => preg_replace('/[^a-zA-Z\s]/', '', $request->name) ?: 'Pelanggan JS',
                'email' => $request->email,
                'phone' => $request->phone,
            ],
            'custom_field1' => $request->name . ' | ' . ($request->duration ?? '-') . ' Hari',
            'custom_field2' => $request->motorName ?? '-',
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // =========================================================
    // FUNGSI BARU UNTUK MENERIMA NOTIFIKASI WEBHOOK MIDTRANS
    // =========================================================
    public function receiveNotification(Request $request)
    {
        // 1. Tangkap data dari Midtrans
        $statusJson = $request->all();

        $orderId = $statusJson['order_id'] ?? null;
        $transactionStatus = $statusJson['transaction_status'] ?? null;

        // 2. Jika status transaksi sukses/lunas (settlement)
        if ($transactionStatus == 'settlement') {

            // ---------------------------------------------------------
            // TULIS LOGIC INPUT GOOGLE SPREADSHEET KAMU DI SINI
            // ---------------------------------------------------------
            // Contoh data yang dikirim Midtrans balik ke kamu (bisa kamu manfaatkan):
            // $customerName = $statusJson['custom_field1'] ?? '';
            // $motor = $statusJson['custom_field2'] ?? '';
            // $amount = $statusJson['gross_amount'] ?? '';
            
        }

        // 3. Beri respon balik ke server Midtrans berupa JSON sukses
        return response()->json(['status' => 'success']);
    }
}