<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\BookingList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reschedule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RouteController extends Controller
{
    public function viewDashboard()
    {
        if (Auth::user()->role == 'admin') {
            $data = [
                'pending' => BookingList::whereStatus('pending')->get()->count(),
                'approved' => BookingList::whereStatus('approved')->get()->count(),
                'rejected' => BookingList::whereStatus('rejected')->get()->count(),
                'canceled' => BookingList::whereStatus('canceled')->get()->count(),
                'rescheduled' => BookingList::whereStatus('rescheduled')->get()->count(),
                'total' => BookingList::all()->count(),
                'room' => Room::all()->count(),
                'user' => User::all()->count(),
                'rescheduleRequests' => Reschedule::with(['user', 'room', 'bookingList'])->orderByDesc('created_at')->take(5)->get(),
            ];
        } elseif (Auth::user()->role == 'user') {
            $data = [
                'today' => BookingList::where('user_id', Auth::user()->id)->where('date', '=', now()->format('Y-m-d'))->get()->count(),
                'myList' => BookingList::where('user_id', Auth::user()->id)->get()->count(),
                'today_lists' => BookingList::where('user_id', Auth::user()->id)->whereStatus('approved')->where('date', '=', now()->format('Y-m-d'))->get(),
                'rescheduled' => Reschedule::where('user_id', Auth::user()->id)->count(),
            ];
        }
        return view('dashboard', $data);
    }

    public function viewRoom()
    {
        try {
            $rooms = Room::all();

            if (request()->ajax()) {
                return view('room.load', compact('rooms'));
            }

            return view('room.index', compact('rooms'));
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
    }

    public function viewBookList()
    {
        try {
            if (Auth::user()->role == 'admin') {
                $lists = BookingList::orderBy('date', 'desc')->get();
            } elseif (Auth::user()->role == 'user') {
                $user_id = Auth::user()->id;
                $lists = BookingList::where('user_id', $user_id)
                                    ->where('status', '!=', 'rescheduled')
                                    ->orderBy('date', 'desc')
                                    ->get();
            }
            
            if (request()->ajax()) {
                return view('booking.load-booking', compact('lists'));
            }

            return view('booking.booking-list', compact('lists'));
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
    }
}
