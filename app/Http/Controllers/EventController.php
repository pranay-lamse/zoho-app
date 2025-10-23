<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Razorpay\Api\Api;

class EventController extends Controller
{
    // Fetch Zoho Backstage events
    public function listEvents()
    {
        $accessToken = ZohoController::getAccessToken();
        $response = Http::withToken($accessToken)
            ->get('https://backstage.zoho.com/api/v1/events');

        return response()->json($response->json());
    }

    // Book ticket via Zoho Bookings
    public function bookTicket(Request $request)
    {
        $accessToken = ZohoController::getAccessToken();

        $response = Http::withToken($accessToken)
            ->post('https://www.zohoapis.com/bookings/v1/appointments', [
                'service_id' => $request->service_id,
                'customer' => [
                    'name' => $request->name,
                    'email' => $request->email,
                ],
                'booking_start_time' => $request->start_time,
                'booking_end_time' => $request->end_time,
            ]);

        $booking = $response->json();
        // Save booking locally (DB) if needed
        return response()->json($booking);
    }

    // Pay ticket (Zoho Pay + Razorpay example)
    public function payTicket($bookingId)
    {
        $accessToken = ZohoController::getAccessToken();

        // Example: create Zoho Pay link
        $response = Http::withToken($accessToken)
            ->post('https://www.zohoapis.com/payments/v1/payment-links', [
                'amount' => 999,
                'currency' => 'INR',
                'description' => 'Event Ticket Booking #' . $bookingId,
                'customer' => [
                    'email' => 'test@example.com',
                    'name' => 'Test User'
                ],
                'redirect_url' => 'https://yourapp.com/payment-success'
            ]);

        $paymentUrl = $response->json()['payment_link']['url'] ?? null;
        return redirect($paymentUrl);
    }

    // Zoho webhook
    public function handleZohoWebhook(Request $request)
    {
        // Validate signature (optional)
        // Update booking/payment status
        return response()->json(['status' => 'received']);
    }

    // Razorpay webhook
    public function handleRazorpayWebhook(Request $request)
    {
        // Validate Razorpay signature
        // Update DB for payment success/failure
        return response()->json(['status' => 'received']);
    }
}
