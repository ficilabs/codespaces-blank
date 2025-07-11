<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SchoolDay;
use App\Models\Attendance;
use App\Models\ClassGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    public function scanner()
    {
        return view('backend.attendance.scanner');
    }

    public function scan(Request $request)
    {
        $request->validate([
            'national_id' => 'required',
        ]);

        $today = Carbon::today();
        $now = Carbon::now();

        $schoolDay = SchoolDay::firstOrCreate([
            'date' => $today->toDateString(),
        ]);

        $user = User::where('national_id', $request->national_id)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Siswa/Guru tidak ditemukan.');
        }

        // Check if already attended
        $alreadyExists = Attendance::where('user_id', $user->id)
            ->where('school_day_id', $schoolDay->id)
            ->exists();

        if ($alreadyExists) {
            return redirect()->back()->with('warning', "{$user->name} sudah absen hari ini.");
        }

        // Check if late (after 07:00 AM)
        $lateLimit = Carbon::createFromTime(7, 0, 0); // 07:00:00
        $status = $now->greaterThan($lateLimit) ? 'TERLAMBAT' : 'HADIR';

        Attendance::create([
            'user_id' => $user->id,
            'school_day_id' => $schoolDay->id,
            'status' => $status,
            'created_at' => $now, // Optional, Laravel sets this automatically
        ]);

        return redirect()->back()->with('success', "{$user->name} berhasil absen sebagai {$status}.");
    }
    
    /**
     * Update the specified attendance status.
     */
    public function update(Request $request, Attendance $attendance)
    {
        // ✅ Validate incoming status
        $request->validate([
            'status' => 'required|in:HADIR,TERLAMBAT,IZIN,SAKIT',
        ]);

        // ✅ Update the attendance record
        $attendance->update([
            'status' => $request->status,
        ]);

        // ✅ Redirect back with success message
        return redirect()->back()->with('success', 'Status kehadiran berhasil diperbarui.');
    }

    public function todayReport(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $schoolDay = SchoolDay::firstOrCreate(['date' => $today]);
        $classGroups = ClassGroup::with('grade')->get();

        foreach ($classGroups as $classGroup) {
            $usersQuery = $classGroup->users()
                ->with(['attendance' => function ($query) use ($schoolDay) {
                    $query->where('school_day_id', $schoolDay->id);
                }]);

            // 🔍 Search
            if ($request->filled('search')) {
                $search = $request->search;
                $usersQuery->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                    ->orWhere('national_id', 'like', "%$search%");
                });
            }

            // 🎯 Filter by attendance status
            if ($request->filled('status')) {
                $status = $request->status;
                $usersQuery->whereHas('attendance', function ($q) use ($schoolDay, $status) {
                    $q->where('school_day_id', $schoolDay->id)
                    ->where('status', $status);
                });
            }

            // ⬆⬇ Sort
            $sortBy = $request->get('sort_by', 'name');
            $sortDir = $request->get('sort_dir', 'asc');
            $usersQuery->orderBy($sortBy, $sortDir);

            $classGroup->paginatedUsers = $usersQuery->paginate(10, ['*'], "page_classgroup_{$classGroup->id}")
                ->withQueryString();
        }

        return view('backend.attendance.today-report', compact('classGroups', 'schoolDay'));    
    }

}
