<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    /**
     * Display a listing of complaints.
     */
    public function index(Request $request)
    {
        $query = Complaint::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $complaints = $query->latest()->paginate(10);

        return view('admin.pengaduan.index', compact('complaints'));
    }

    /**
     * Display the specified complaint.
     */
    public function show(Complaint $complaint)
    {
        $complaint->load('user');
        return view('admin.pengaduan.show', compact('complaint'));
    }

    /**
     * Update the status of a complaint.
     */
    public function updateStatus(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => ['required', 'in:pending,process,resolved'],
        ]);

        $complaint->update(['status' => $request->status]);

        $statusLabels = [
            'pending'  => 'Pending',
            'process'  => 'Diproses',
            'resolved' => 'Selesai',
        ];

        return redirect()->back()
            ->with('success', 'Status pengaduan diubah menjadi: ' . $statusLabels[$request->status]);
    }

    /**
     * Export complaints data to CSV.
     */
    public function export()
    {
        $fileName = 'data_pengaduan_' . date('Ymd_His') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Tanggal', 'Pengirim', 'Judul', 'Deskripsi', 'Status']);

            $complaints = Complaint::with('user')->get();

            foreach ($complaints as $index => $c) {
                $statusMap = [
                    'pending'  => 'Pending',
                    'process'  => 'Diproses',
                    'resolved' => 'Selesai',
                ];
                
                fputcsv($file, [
                    $index + 1,
                    $c->created_at->format('d/m/Y H:i'),
                    $c->user->name ?? '-',
                    $c->title,
                    $c->description,
                    $statusMap[$c->status] ?? $c->status
                ]);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, $fileName, $headers);
    }
}
