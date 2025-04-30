<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    /**
     * Display a listing of the user's achievements.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Get achievements for the currently authenticated user
        $achievements = $request->user()->achievements()
                                ->with('habit:id,name') // Eager load habit name for context
                                ->latest('completion_date') // Order by completion date
                                ->get();

        return response()->json($achievements);
    }

    // Các phương thức khác (store, show, update, destroy) không được yêu cầu
    // cho achievements trong prompt ban đầu, vì chúng được tạo tự động.
    // Nếu cần, bạn có thể thêm chúng sau.
}
