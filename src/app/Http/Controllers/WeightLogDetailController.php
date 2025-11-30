<?php

namespace App\Http\Controllers;

use App\Models\WeightTarget;
use App\Models\WeightLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeightLogDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($weightLogId)
    {
        $log = WeightLog::findOrFail($weightLogId);

        if (auth()->id() !== $log->user_id) {
            abort(403);
        }
        $user = Auth::user();

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

        return view('weight_logs_detail',[
        'log' => $log,
        'lastedTarget' => $lastedTarget,
        'latestLog' => $latestLog,
        'weightDiff' => $weightDiff,
        'logs' => $logs,
        ]);
    }

    public function update(Request $request, $weightLogId)
    {
        $log = WeightLog::findOrFail($weightLogId);

        if (auth()->id() !== $log->user_id) {
            abort(403);
        }

        $request->validate([
            'date' => 'required|date',
            'weight' => 'required|numeric|min:0',
            'calories' => 'nullable|integer|min:0',
            'exercise_time' => 'nullable|date_format:H:i',
            'exercise_content' => 'nullable|string|max:1000',
        ]);
        $log->update([
            'date' => $request->date,
            'weight' => $request->weight,
            'calories' => $request->calories ?? 0,
            'exercise_time' => $request->exercise_time ? $request->exercise_time . ':00' : '00:00:00',
            'exercise_content' => $request->exercise_content,
        ]);

        return redirect('/weight_logs')->with('success', '記録を更新しました！');
    }

    public function delete($weightLogId)
    {
        $log = WeightLog::findOrFail($weightLogId);

        if (auth()->id() !== $log->user_id) {
            abort(403);
        }

        $log->delete();

        return redirect('weight_logs')->with('success', '記録を削除しました！');
    }
}
