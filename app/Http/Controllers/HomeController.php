<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.home.index');
    }

    public function orderService(Request $request, String $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|regex:/^[0-9]+$/|min:10|max:15',
            'deadline' => 'required|date|after:now',
            'description' => 'required|string|max:1000',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'whatsapp_number.required' => 'Nomor WhatsApp wajib diisi.',
            'whatsapp_number.regex' => 'Nomor WhatsApp hanya boleh mengandung angka.',
            'whatsapp_number.min' => 'Nomor WhatsApp harus minimal 10 digit.',
            'whatsapp_number.max' => 'Nomor WhatsApp tidak boleh lebih dari 15 digit.',
            'deadline.required' => 'Batas waktu wajib diisi.',
            'deadline.date' => 'Batas waktu harus berupa tanggal yang valid.',
            'deadline.after' => 'Batas waktu harus lebih dari waktu sekarang.',
            'description.required' => 'Deskripsi wajib diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi tidak boleh lebih dari 1000 karakter.',
        ]);

        $data = [
            'service_id' => $id,
            'name' => $request->name,
            'whatsapp_number' => $request->whatsapp_number,
            'deadline' => $request->deadline,
            'description' => $request->description,
        ];

        if ($request->has('referral_code')) {
            $data['referral_code'] = $request->referral_code;
        }

        $order = Order::create($data);

        $message = "*Detail Order*\n\n";
        $message .= "*Nama:* " . $order->name . "\n";
        $message .= "*Nomor WhatsApp:* " . $order->whatsapp_number . "\n";
        $message .= "*Batas Waktu:* " . $order->deadline . "\n";
        $message .= "*Deskripsi:* " . $order->description . "\n";
        $message .= "*Kode Order:* " . $order->order_code . "\n\n";

        $message .= "*Jasa:* " . $order->service->title . "\n";
        $message .= "*Harga Jasa:* Rp " . number_format($order->service->price, 2, ',', '.') . "\n\n";

        return redirect()->away('https://wa.me/62895420984780?text=' . urlencode($message));
    }

    public function orderCourse(Request $request, String $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|regex:/^[0-9]+$/|min:10|max:15',
            'deadline' => 'required|date|after:now',
            'description' => 'required|string|max:1000',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'whatsapp_number.required' => 'Nomor WhatsApp wajib diisi.',
            'whatsapp_number.regex' => 'Nomor WhatsApp hanya boleh mengandung angka.',
            'whatsapp_number.min' => 'Nomor WhatsApp harus minimal 10 digit.',
            'whatsapp_number.max' => 'Nomor WhatsApp tidak boleh lebih dari 15 digit.',
            'deadline.required' => 'Batas waktu wajib diisi.',
            'deadline.date' => 'Batas waktu harus berupa tanggal yang valid.',
            'deadline.after' => 'Batas waktu harus lebih dari waktu sekarang.',
            'description.required' => 'Deskripsi wajib diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi tidak boleh lebih dari 1000 karakter.',
        ]);

        $data = [
            'course_id' => $id,
            'name' => $request->name,
            'whatsapp_number' => $request->whatsapp_number,
            'deadline' => $request->deadline,
            'description' => $request->description,
        ];

        if ($request->has('referral_code')) {
            $data['referral_code'] = $request->referral_code;
        }

        $order = Order::create($data);

        $message = "*Detail Order*\n\n";
        $message .= "*Nama:* " . $order->name . "\n";
        $message .= "*Nomor WhatsApp:* " . $order->whatsapp_number . "\n";
        $message .= "*Batas Waktu:* " . $order->deadline . "\n";
        $message .= "*Deskripsi:* " . $order->description . "\n";
        $message .= "*Kode Order:* " . $order->order_code . "\n\n";

        $message .= "*Kursus:* " . $order->course->title . "\n";
        $message .= "*Harga Kursus:* Rp " . number_format($order->course->price, 2, ',', '.') . "\n\n";

        return redirect()->away('https://wa.me/62895420984780?text=' . urlencode($message));
    }
}
