<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TargetWeightController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function goalSetting()
    {
        $user = Auth::user();

        $lastedTarget = WeightTarget::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('goal_setting', [
            'lastedTarget' => $lastedTarget,
        ]);
    }

    public function showGoalSetting()
    {
        $userId = Auth::id();
        $user = Auth::user();

        $latestLog = WeightLog::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $lastedTarget = WeightTarget::where('user_id', $userId)
        ->latest()
        ->first();

        $logs = WeightLog::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->paginate(8);

        $weightDiff = 0;
        if ($latestLog && $lastedTarget) {
            $weightDiff = $latestLog->weight - $lastedTarget->target_weight;
        }

        $logs = WeightLog::where('user_id', $user->id)->orderBy('date', 'desc')->paginate(8);

        return view('goal_setting',[
            'lastedTarget' => $lastedTarget,
            'latestLog' => $latestLog,
            'weightDiff' => $weightDiff,
            'logs' => $logs,
        ]);
    }

    public function updateTargetWeight(Request $request)
    {
        $request->validate([
            'target_weight' => 'required|numeric|min:1',
        ]);

        $userId = Auth::id();

        WeightTarget::create([
            'user_id' => $userId,
            'target_weight' => $request->target_weight,
        ]);

        return redirect('/weight_logs')->with('success', '目標体重を更新しました。');
    }
}
