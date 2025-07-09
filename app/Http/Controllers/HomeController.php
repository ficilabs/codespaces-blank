<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\SchoolDay;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $schoolDay = SchoolDay::firstOrCreate(['date' => $today]);

        $query = Attendance::with(['user.classGroup.grade'])
            ->where('school_day_id', $schoolDay->id);

        // 🔍 Filter by keyword
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->whereHas('user', function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                ->orWhere('national_id', 'like', "%{$keyword}%");
            });
        }

        // 🎓 Filter by class_group_id
        if ($request->filled('class_group_id')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('class_group_id', $request->class_group_id);
            });
        }

        // 🟢 Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 🔁 Sort
        if ($request->filled('sort_by')) {
            $query->orderBy($request->sort_by, $request->get('sort_dir', 'asc'));
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $attendanceLogs = $query->paginate(10)->withQueryString();

        // For filter options
        $classGroups = \App\Models\ClassGroup::with('grade')->get();

        // Totals for students only
        $totalHadir = Attendance::where('school_day_id', $schoolDay->id)
            ->where('status', 'HADIR')
            ->whereHas('user', fn($q) => $q->role('Student'))
            ->count();

        $totalIzin = Attendance::where('school_day_id', $schoolDay->id)
            ->where('status', 'IZIN')
            ->whereHas('user', fn($q) => $q->role('Student'))
            ->count();

        $totalSakit = Attendance::where('school_day_id', $schoolDay->id)
            ->where('status', 'SAKIT')
            ->whereHas('user', fn($q) => $q->role('Student'))
            ->count();

        $totalTerlambat = Attendance::where('school_day_id', $schoolDay->id)
            ->where('status', 'TERLAMBAT')
            ->whereHas('user', fn($q) => $q->role('Student'))
            ->count();

        // Total registered students (who belong to a class)
        $totalStudents = \App\Models\User::role('Student')
            ->whereHas('classGroup')
            ->count();

        // Students who did not attend at all
        $totalTidakMasuk = $totalStudents - ($totalHadir + $totalIzin + $totalSakit + $totalTerlambat);


        return view('backend.home.main', compact(
            'schoolDay', 'attendanceLogs', 'classGroups',
            'totalHadir', 'totalIzin', 'totalSakit', 'totalTidakMasuk','totalTerlambat', 'totalStudents'
        ));
    }

}
