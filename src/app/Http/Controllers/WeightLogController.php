<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WeightLogController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $userId = Auth::id();

        $logs = WeightLog::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->paginate(8);

        $latestLog = WeightLog::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $lastedTarget = WeightTarget::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $weightDiff = 0;
        if ($latestLog && $lastedTarget) {
            $weightDiff = $latestLog->weight - $lastedTarget->target_weight;
        }

        $logs = WeightLog::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->paginate(8);

        $query = WeightLog::where('user_id', $user->id)
            ->orderBy('date', 'desc');

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        $logs = $query->paginate(8)->withQueryString();

        return view('weight_logs', [
            'lastedTarget' => $lastedTarget,
            'latestLog' => $latestLog,
            'weightDiff' => $weightDiff,
            'logs' => $logs,
        ]);
    }

    public function goalSetting()
    {
        $user = Auth::user();
        $userId = Auth::id();

        $latestLog = WeightLog::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $lastedTarget = WeightTarget::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $weightDiff = 0;
        if ($latestLog && $lastedTarget) {
            $weightDiff = $latestLog->weight - $lastedTarget->target_weight;
        }
        $logs = WeightLog::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->paginate(8);

        return view('goal_setting', [
            'lastedTarget' => $lastedTarget,
            'latestLog' => $latestLog,
            'weightDiff' => $weightDiff,
            'logs' => $logs,
        ]);
    }
}
