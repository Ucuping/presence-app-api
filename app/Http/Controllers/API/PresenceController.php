<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Presence;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresenceController extends Controller
{
    public function getData(Request $request)
    {
        try {
            setlocale(LC_ALL, 'IND');
            Carbon::setLocale('id');
            $presences = Presence::whereUserId(Auth::user()->id)->orderById('desc');
            if ($request->limit) {
                $presences = $presences->take($request->limit);
            }
            $presences = $presences->get();
            $presences = $presences->map(function ($presence) {
                $presence->date = Carbon::parse($presence->date)->isoFormat('D MMMM Y');
                return $presence;
            });
            return response()->json([
                'success' => true,
                'data' => $presences,
                'message' => 'Berhasil mengambil data'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $strParse = explode('-', $request->qr_data);
            $type = $strParse[0] == 'datang' ? 'checkin' : 'checkout';
            $date = Carbon::createFromFormat('Y-m-d', $strParse[1] . '-' . $strParse[2] . '-' . $strParse[3]);
            $request->merge(['type' => $type, 'date' => $date->format('Y-m-d')]);
            $shift = Auth::user()->shift()->first();
            if ($type == 'checkin') {
                $checkin = Presence::where(['user_id' => Auth::user()->id, 'type' => 'checkin', 'date' => $date->format('Y-m-d')])->first();
                if (!$checkin) {
                    if (Carbon::now()->format('H:i:s') < $shift->start_time_entry) {
                        $description = 'Masuk | Tepat Waktu';
                    } else {
                        $description = 'Masuk | Terlambat';
                    }
                    $request->merge(['description' => $description]);
                    $presence = Presence::create([
                        'user_id' => Auth::user()->id,
                        'shift_id' => $shift->id,
                        'date' => $request->date,
                        'type' => $request->type,
                        'time_in' => Carbon::now()->format('H:i:s'),
                        'latitude' => $request->latitude,
                        'longitude' => $request->longitude,
                        'description' => $request->description,
                    ]);
                    $data = [
                        'date' => Carbon::parse($presence->date)->isoFormat('D MMMM Y'),
                        'type' => $presence->type,
                        'time_in' => $presence->time_in,
                        'latitude' => $presence->latitude,
                        'longitude' => $presence->longitude,
                        'description' => $presence->description,
                    ];
                    return response()->json([
                        'success' => true,
                        'data' => $data,
                        'message' => 'Berhasil menyimpan absensi'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Kamu sudah melakukan absensi masuk hari ini'
                    ], 400);
                }
            } else {
                $checkout = Presence::where(['user_id' => Auth::user()->id, 'type' => 'checkout', 'date' => $date->format('Y-m-d')])->first();
                if (!$checkout) {
                    if (Carbon::now()->format('H:i:s') < $shift->start_exit) {
                        Presence::where(['user_id' => Auth::user()->id, 'date' => Carbon::now()->format('Y-m-d')])->delete();
                        return response()->json([
                            'success' => true,
                            'message' => 'Kamu dianggap bolos karena pulang lebih awal'
                        ]);
                    } else {
                        $description = 'Pulang | Tepat Waktu';
                        $request->merge(['description' => $description]);
                        $presence = Presence::create([
                            'user_id' => Auth::user()->id,
                            'shift_id' => $shift->id,
                            'date' => $request->date,
                            'type' => $request->type,
                            'time_in' => Carbon::now()->format('H:i:s'),
                            'latitude' => $request->latitude,
                            'longitude' => $request->longitude,
                            'description' => $request->description,
                        ]);
                        $data = [
                            'date' => Carbon::parse($presence->date)->isoFormat('D MMMM Y'),
                            'type' => $presence->type,
                            'time_in' => $presence->time_in,
                            'latitude' => $presence->latitude,
                            'longitude' => $presence->longitude,
                            'description' => $presence->description,
                        ];
                        return response()->json([
                            'success' => true,
                            'data' => $data,
                            'message' => 'Berhasil menyimpan data absensi'
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Kamu sudah melakukan absensi pulang hari ini'
                    ], 400);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }
}
