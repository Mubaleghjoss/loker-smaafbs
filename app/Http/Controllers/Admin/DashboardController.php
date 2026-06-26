<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ApplicationStatus;
use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Models\Application;
use App\Models\Position;

class DashboardController extends Controller
{
    public function redirectHome()
    {
        $admin = auth('admin')->user();

        if ($admin instanceof AdminUser) {
            return redirect()->route($admin->firstAllowedRouteName());
        }

        return redirect()->route('admin.login');
    }

    public function index()
    {
        $totalApplicants = Application::query()->count();

        $byStatus = Application::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->all();

        $statusCards = [];
        foreach (ApplicationStatus::cases() as $status) {
            $statusCards[] = [
                'value' => $status->value,
                'label' => $status->label(),
                'total' => (int)($byStatus[$status->value] ?? 0),
                'badgeClasses' => $status->badgeClasses(),
            ];
        }

        $byPosition = Position::query()
            ->leftJoin('applications', 'applications.position_id', '=', 'positions.id')
            ->where('positions.is_active', true)
            ->groupBy('positions.id', 'positions.name')
            ->orderBy('positions.sort_order')
            ->orderBy('positions.name')
            ->selectRaw('positions.name as name, COUNT(applications.id) as total')
            ->get();

        $latestApplicants = Application::query()
            ->orderByDesc('submitted_at')
            ->limit(10)
            ->get();

        return view('admin.dashboard', [
            'totalApplicants' => $totalApplicants,
            'statusCards' => $statusCards,
            'byPosition' => $byPosition,
            'latestApplicants' => $latestApplicants,
        ]);
    }
}
