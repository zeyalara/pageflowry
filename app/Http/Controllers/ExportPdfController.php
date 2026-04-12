<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\ContentBrief;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Auth;

class ExportPdfController extends Controller
{
    private $pdf;

    public function __construct(PDF $pdf)
    {
        $this->pdf = $pdf;
    }

    /**
     * PDF: semua brand milik user login (sama cakupan dengan halaman Brand).
     */
    public function brands()
    {
        $brands = Brand::where('user_id', Auth::id())
            ->withCount([
                'contentTasks as contents_count' => function ($q) {
                    $q->where('user_id', Auth::id());
                },
            ])
            ->orderBy('name')
            ->get();

        $user = Auth::user();

        $pdf = $this->pdf->loadView('exports.brands-pdf', [
            'brands' => $brands,
            'user' => $user,
            'exportedAt' => now(),
        ])
            ->setPaper('a4', 'landscape');

        $filename = 'daftar-brand-'.now()->format('Y-m-d_His').'.pdf';

        return $pdf->download($filename);
    }

    /**
     * PDF: semua tugas konten (content briefs) milik user login.
     */
    public function contentTasks()
    {
        $contentBriefs = ContentBrief::where('user_id', Auth::id())
            ->with('brand')
            ->orderByDesc('created_at')
            ->get();

        $user = Auth::user();

        $pdf = $this->pdf->loadView('exports.content-tasks-pdf', [
            'contentBriefs' => $contentBriefs,
            'user' => $user,
            'exportedAt' => now(),
        ])
            ->setPaper('a4', 'landscape');

        $filename = 'daftar-tugas-konten-'.now()->format('Y-m-d_His').'.pdf';

        return $pdf->download($filename);
    }
}
