<?php

namespace App\Http\Controllers;

use App\Models\BookingList;
use App\Models\Room;
use App\Models\RoomBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rooms = Room::where('status', 'able')->get();

        return view('booking.form', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'date' => 'required|date',
            'start' => 'required|date_format:H:i',
            'end' => 'required|date_format:H:i|after:start',
            'need' => 'required|string|max:255',
        ], [
            'end.after' => 'Waktu selesai harus lebih besar dari waktu mulai.',
        ]);

        if ($this->hasSameDateBookingConflict($request->room_id, $request->date, $request->start, $request->end)) {
            return redirect()->back()->withErrors(['error' => 'Booking pada tanggal yang sama harus memiliki jarak minimal 1 jam dengan booking lain.'])->withInput();
        }

        BookingList::create([
            'user_id' => Auth::user()->id,
            'room_id' => $request->room_id,
            'date' => $request->date,
            'start' => $request->start,
            'end' => $request->end,
            'need' => $request->need,
            'status' => 'pending',
        ]);

        return redirect()->route('book-list')->with('success', 'Berhasil Booking Ruangan \n Mohon Tunggu Konfirmasi dari Admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BookingList  $bookingList
     * @return \Illuminate\Http\Response
     */
    public function show(BookingList $bookingList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BookingList  $bookingList
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rooms = Room::all();
        $bookingList = BookingList::find($id);

        if (!$bookingList || $bookingList->user_id !== Auth::user()->id) {
            abort(404);
        }

        if ($bookingList->date->lte(now()->addDay()) && in_array($bookingList->status, ['pending', 'approved'])) {
            return redirect()->route('book-list')->withErrors(['error' => 'Booking tidak bisa diubah dalam waktu 2 hari sebelum tanggal acara.']);
        }

        return view('booking.form', compact('bookingList', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BookingList  $bookingList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bookingList = BookingList::find($id);

        if (!$bookingList || $bookingList->user_id !== Auth::user()->id) {
            abort(404);
        }

        if ($bookingList->date->lte(now()->addDay()) && in_array($bookingList->status, ['pending', 'approved'])) {
            return redirect()->route('book-list')->withErrors(['error' => 'Booking tidak bisa diubah dalam waktu 2 hari sebelum tanggal acara.']);
        }

        $request->validate([
            'date' => 'required|date',
            'start' => 'required|date_format:H:i',
            'end' => 'required|date_format:H:i|after:start',
            'need' => 'required|string|max:255',
        ], [
            'end.after' => 'Waktu selesai harus lebih besar dari waktu mulai.',
        ]);

        if ($this->hasSameDateBookingConflict($bookingList->room_id, $request->date, $request->start, $request->end, $id)) {
            return redirect()->back()->withErrors(['error' => 'Booking pada tanggal yang sama harus memiliki jarak minimal 1 jam dengan booking lain.'])->withInput();
        }

        if ($bookingList->status === 'approved') {
            RoomBooking::where('booking_id', $bookingList->id)->delete();
        }

        $bookingList->update([
            'date' => $request->date,
            'start' => $request->start,
            'end' => $request->end,
            'need' => $request->need,
            'status' => 'pending',
        ]);

        return redirect()->route('book-list')->with('success', 'Berhasil Edit Data Booking');
    }

    private function hasSameDateBookingConflict($roomId, $date, $start, $end, $excludeId = null)
    {
        $newStart = Carbon::createFromFormat('H:i', $start);
        $newEnd = Carbon::createFromFormat('H:i', $end);

        $bookings = BookingList::where('room_id', $roomId)
            ->where('date', $date)
            ->where('status', '!=', 'canceled')
            ->when($excludeId, fn($query) => $query->where('id', '!=', $excludeId))
            ->get();

        foreach ($bookings as $booking) {
            $existingStart = Carbon::createFromFormat('H:i', $booking->start->format('H:i'));
            $existingEnd = Carbon::createFromFormat('H:i', $booking->end->format('H:i'));

            if ($newStart->lt($existingEnd->copy()->addHour()) && $newEnd->gt($existingStart->copy()->subHour())) {
                return true;
            }
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookingList  $bookingList
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookingList $bookingList)
    {
    }
}
