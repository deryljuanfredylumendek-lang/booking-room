<?php

namespace App\Http\Controllers;

use App\Models\BookingList;
use App\Models\RoomBooking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reschedule;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function cancelBooking($id)
    {
        try {
            $bookingList = BookingList::find($id);

            if (!$bookingList || $bookingList->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking tidak ditemukan atau tidak ada akses.',
                ], 404);
            }

            if ($bookingList->date->lte(now()->addDay())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking tidak dapat dibatalkan dalam waktu 2 hari sebelum jadwal.',
                ], 422);
            }

            $bookingList->update([
                'status' => 'canceled'
            ]);
            
            RoomBooking::where('booking_id', $bookingList->id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Membatalkan Penyewaan'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membatalkan booking.',
            ], 500);
        }
    }

    public function requestReschedule(Request $request, $id)
    {
        try {
            $request->validate([
                'message' => 'required|string|min:5',
            ]);

            $bookingList = BookingList::find($id);

            if (!$bookingList || $bookingList->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking tidak ditemukan atau tidak ada akses.',
                ], 404);
            }

            if (!in_array($bookingList->status, ['pending', 'approved'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking hanya bisa di-reschedule untuk status pending atau approved.',
                ], 422);
            }

            if ($bookingList->date->lte(now()->addDay())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking tidak bisa di-reschedule dalam waktu 2 hari sebelum jadwal.',
                ], 422);
            }

            if ($bookingList->status === 'approved') {
                RoomBooking::where('booking_id', $bookingList->id)->delete();
            }

            $bookingList->update([
                'status' => 'rescheduled'
            ]);

            $reschedule = Reschedule::create([
                'room_id' => $bookingList->room_id,
                'user_id' => $bookingList->user_id,
                'booking_id' => $bookingList->id,
                'message' => $request->message,
            ]);

            $newBookingList = BookingList::create([
                'user_id' => $bookingList->user_id,
                'room_id' => $bookingList->room_id,
                'date' => $bookingList->date,
                'start' => $bookingList->start,
                'end' => $bookingList->end,
                'need' => $bookingList->need,
                'status' => 'pending'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Permintaan reschedule berhasil terkirim dan ditambahkan ke daftar Reschedule.',
                'url' => "/booking/{$newBookingList->id}/edit",
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first(),
            ], 422);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses reschedule.',
            ], 500);
        }
    }

    public function viewReschedule()
    {
        try {
            $reschedules = Reschedule::where('user_id', Auth::user()->id)
                                    ->orderBy('reschedule')->get();

            if (request()->ajax()) {
                return view('booking.load-reschedule', compact('reschedules'));
            }

            return view('booking.reschedule', compact('reschedules'));
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
    }
    
    public function rescheduleBooking(Request $request, $id)
    {
        try {
            $request->validate([
                'reschedule' => 'required|in:yes,no',
                'booking_id' => 'required|integer|exists:booking_lists,id',
            ]);

            $reschedule = Reschedule::find($id);
            if (!$reschedule || $reschedule->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data reschedule tidak ditemukan atau tidak ada akses.',
                ], 404);
            }

            $reschedule->update([
                'reschedule' => $request->reschedule,
            ]);

            if ($request->reschedule === 'yes') {
                $bookingList = BookingList::find($request->booking_id);
                if (!$bookingList || $bookingList->user_id !== Auth::id()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data booking tidak ditemukan atau tidak ada akses.',
                    ], 404);
                }

                $bookingList->update([
                    'status' => 'rescheduled'
                ]);

                $newBookingList = BookingList::create([
                    'user_id' => $bookingList->user_id,
                    'room_id' => $bookingList->room_id,
                    'date' => $bookingList->date,
                    'start' => $bookingList->start,
                    'end' => $bookingList->end,
                    'need' => $bookingList->need,
                    'status' => 'pending'
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Penjadwalan ulang dikonfirmasi. Silakan atur jadwal baru.',
                    'url' => "/booking/{$newBookingList->id}/edit",
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Permintaan reschedule ditolak. Silakan ajukan booking baru jika perlu.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first(),
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses reschedule.',
            ], 500);
        }
    }
}
