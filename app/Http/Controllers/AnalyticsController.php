<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\ContentTask;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        $tasks = ContentTask::with([
                'brand',
                'productions' => fn ($q) => $q->latest()->limit(1),
            ])
            ->orderByDesc('updated_at')
            ->get();

        $total = $tasks->count();
        $stats = [
            'total' => $total,
            'in_production' => $tasks->where('status', 'in_production')->count(),
            'need_revision' => $tasks->where('status', 'need_revision')->count(),
            'ready_to_publish' => $tasks->where('status', 'ready_to_publish')->count(),
            'published' => $tasks->where('status', 'published')->count(),
        ];

        $brands = Brand::orderBy('name')->get();
        $brandStats = $brands->map(function ($brand) use ($tasks) {
            return [
                'name' => $brand->name,
                'count' => $tasks->where('brand_id', $brand->id)->count(),
            ];
        })->filter(fn ($row) => $row['count'] > 0)->values();

        $monthStart = Carbon::now()->startOfMonth();
        $monthlyTrend = collect(range(5, 0))->reverse()->map(function ($offset) use ($monthStart, $tasks) {
            $month = (clone $monthStart)->subMonths($offset);
            $count = $tasks->filter(function ($task) use ($month) {
                return optional($task->created_at)->format('Y-m') === $month->format('Y-m');
            })->count();

            return [
                'label' => $month->translatedFormat('M'),
                'value' => $count,
            ];
        })->values();

        return view('admin.analytics.index', compact('tasks', 'stats', 'brandStats', 'monthlyTrend'));
    }

    public function create()
    {
        return view('admin.analytics.create');
    }

    public function store(Request $request)
    {
        // Logic for storing analytics data
        return redirect()->route('analytics.index')->with('success', 'Analytics created successfully');
    }

    public function edit($id)
    {
        return view('admin.analytics.edit', ['id' => $id]);
    }

    public function update(Request $request, $id)
    {
        // Logic for updating analytics data
        return redirect()->route('analytics.index')->with('success', 'Analytics updated successfully');
    }

    public function destroy($id)
    {
        // Logic for deleting analytics data
        return redirect()->route('analytics.index')->with('success', 'Analytics deleted successfully');
    }
}
