<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\ContentTask;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $tasks = ContentTask::with([
                'brand',
                'creator',
                'productions' => fn ($q) => $q->latest()->limit(1),
            ])
            ->where('user_id', Auth::id())
            ->orderByDesc('updated_at')
            ->get();

        $stats = [
            'total' => $tasks->count(),
            'published' => $tasks->where('status', 'published')->count(),
            'ready_to_publish' => $tasks->where('status', 'ready_to_publish')->count(),
            'need_revision' => $tasks->where('status', 'need_revision')->count(),
        ];

        $brands = Brand::where('user_id', Auth::id())->orderBy('name')->get();

        return view('admin.report.index', compact('tasks', 'stats', 'brands'));
    }

    public function create()
    {
        return view('admin.report.create');
    }

    public function store(Request $request)
    {
        // Logic for storing report data
        return redirect()->route('report.index')->with('success', 'Report created successfully');
    }

    public function edit($id)
    {
        return view('admin.report.edit', ['id' => $id]);
    }

    public function update(Request $request, $id)
    {
        // Logic for updating report data
        return redirect()->route('report.index')->with('success', 'Report updated successfully');
    }

    public function destroy($id)
    {
        // Logic for deleting report data
        return redirect()->route('report.index')->with('success', 'Report deleted successfully');
    }
}
