<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ClassGroup;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ClassStudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $classGroupId = $request->class_group_id;

        $students = User::role('Student')
            ->when($search, fn($q) => $q->where('name', 'like', "%$search%")
                ->orWhere('national_id', 'like', "%$search%"))
            ->when($classGroupId, fn($q) => $q->where('class_group_id', $classGroupId))
            ->with('classGroup.grade')
            ->orderBy('name') // sort by name
            ->paginate(10)
            ->withQueryString();

        $classGroups = ClassGroup::with('grade')->get();

        // For QR preview modal (no QR lib needed)
        $qrData = User::role('Student')
            ->when($classGroupId, fn($q) => $q->where('class_group_id', $classGroupId))
            ->with('classGroup.grade')
            ->get()
            ->map(function ($user) {
                return [
                    'nama' => $user->name,
                    'nis' => $user->national_id,
                    'kelas' => optional($user->classGroup?->grade)->name . ' - ' . $user->classGroup?->group_number,
                ];
        });

        return view('backend.class-students.index', compact('students', 'classGroups', 'search', 'classGroupId','qrData'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'class_group_id' => 'nullable|exists:class_groups,id',
        ]);

        $user->update([
            'class_group_id' => $request->class_group_id,
        ]);

        return redirect()->route('class-students.index')->with('success', 'Kelas siswa berhasil diperbarui.');
    }

    /**
     * Generate QR PDF using dompdf (external QR image)
     */
    public function downloadSingleCard(User $user)
    {
        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?data={$user->national_id}&size=100x100";
        $qrImage = base64_encode(file_get_contents($qrUrl));

        $logoPath = public_path('assets/img/logo/logo.png');
        $logoImage = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : null;

        $card = [
            'nama' => $user->name,
            'nis' => $user->national_id,
            'kelas' => $user->classGroup?->grade->name . ' - ' . $user->classGroup?->group_number,
            'qr_base64' => $qrImage,
            'logo_base64' => $logoImage,
        ];

        return \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.single-card', compact('card'))
            ->setPaper([0, 0, 250, 400])
            ->download("Kartu_{$user->name}.pdf");
    }


    public function downloadQrCards(Request $request)
    {
        $students = User::role('Student')
            ->when($request->class_group_id, fn($q) => $q->where('class_group_id', $request->class_group_id))
            ->with('classGroup.grade')
            ->get();

        $cards = $students->map(function ($student) {
            return [
                'nama' => $student->name,
                'nis' => $student->national_id,
                'kelas' => optional($student->classGroup?->grade)->name . ' - ' . $student->classGroup?->group_number,
                'qr' => base64_encode(file_get_contents("https://api.qrserver.com/v1/create-qr-code/?data={$student->national_id}&size=100x100")),
            ];
        });

        $logo = base64_encode(file_get_contents(public_path('img/logo-sekolah.png')));

        return Pdf::loadView('exports.qr-cards', compact('cards', 'logo'))
            ->setPaper('a4', 'portrait')
            ->download('kartu-qr-siswa.pdf');
    }
}
