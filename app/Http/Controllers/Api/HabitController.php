<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Habit;
use App\Models\HabitProgress;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

// Thêm các use statement cho OpenAPI
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Habits', description: 'API Endpoints for managing user habits')]
class HabitController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/habits",
     *      operationId="getHabitsList",
     *      tags={"Habits"},
     *      summary="Get list of user's habits",
     *      description="Returns list of habits for the authenticated user",
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Habit")
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     *
     * Display a listing of the user's habits.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $habits = $request->user()->habits()->latest()->get();
        return response()->json($habits);
    }

    /**
     * Store a newly created habit in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'target_days' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $habit = $request->user()->habits()->create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'target_days' => $request->target_days,
            'completed' => false, // Default to not completed
        ]);

        return response()->json($habit, 201);
    }

    /**
     * Display the specified habit.
     *
     * @param  \App\Models\Habit  $habit
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Habit $habit)
    {
        // Policy check: Ensure the habit belongs to the authenticated user
        if (Auth::id() !== $habit->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        // Eager load progress if needed
        // $habit->load('progress'); 
        return response()->json($habit);
    }

    /**
     * Update the specified habit in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Habit  $habit
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Habit $habit)
    {
        // Policy check
        if (Auth::id() !== $habit->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'start_date' => 'sometimes|required|date',
            'target_days' => 'sometimes|required|integer|min:1',
            // 'completed' could be updated manually if needed, but usually handled by progress
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $habit->update($request->only(['name', 'start_date', 'target_days']));

        // Recalculate completion status after update if target_days changed
        $this->checkAndCreateAchievement($habit->refresh());

        return response()->json($habit);
    }

    /**
     * Remove the specified habit from storage.
     *
     * @param  \App\Models\Habit  $habit
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Habit $habit)
    {
        // Policy check
        if (Auth::id() !== $habit->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Related progress and achievements will be deleted due to cascade constraints
        $habit->delete();

        return response()->json(null, 204); // No content
    }

    // --- Habit Progress Methods ---

    /**
     * Get progress for the specified habit.
     *
     * @param  \App\Models\Habit  $habit
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProgress(Habit $habit)
    {
        // Policy check
        if (Auth::id() !== $habit->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $progress = $habit->progress()->orderBy('date', 'asc')->get();
        return response()->json($progress);
    }

    /**
     * Store a new progress entry for the habit (mark day as checked).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Habit  $habit
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeProgress(Request $request, Habit $habit)
    {
        // Policy check
        if (Auth::id() !== $habit->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'date' => 'required|date|unique:habit_progress,date,NULL,id,habit_id,' . $habit->id, // Unique for this habit
            'status' => 'sometimes|string|in:checked,skipped', // Allow 'skipped' if needed
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Prevent adding progress if habit is already marked completed
        if ($habit->completed) {
             return response()->json(['message' => 'Habit already completed'], 400);
        }

        $progressDate = Carbon::parse($request->date)->startOfDay();
        $startDate = Carbon::parse($habit->start_date)->startOfDay();

        // Optional: Prevent adding progress for dates before the habit started
        if ($progressDate->lt($startDate)) {
             return response()->json(['message' => 'Cannot add progress before habit start date'], 400);
        }

        $progress = $habit->progress()->create([
            'date' => $progressDate,
            'status' => $request->input('status', 'checked'), // Default to 'checked'
        ]);

        // Check if the habit is now completed and create achievement if so
        $this->checkAndCreateAchievement($habit);

        return response()->json($progress, 201);
    }

    /**
     * Remove a progress entry for a specific date.
     *
     * @param  \App\Models\Habit  $habit
     * @param  string  $date // Route model binding for date might be tricky, using string
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyProgress(Habit $habit, $date)
    {
        // Policy check
        if (Auth::id() !== $habit->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $progressDate = Carbon::parse($date)->toDateString(); // Ensure consistent date format
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid date format'], 400);
        }

        $progress = $habit->progress()->where('date', $progressDate)->first();

        if (!$progress) {
            return response()->json(['message' => 'Progress entry not found for this date'], 404);
        }

        $progress->delete();

        // Re-check completion status and potentially remove achievement
        $this->checkAndRemoveAchievement($habit);

        return response()->json(null, 204);
    }

    // --- Helper Methods ---

    /**
     * Check habit completion and create achievement if needed.
     *
     * @param \App\Models\Habit $habit
     * @return void
     */
    protected function checkAndCreateAchievement(Habit $habit)
    {
        $checkedDaysCount = $habit->progress()->where('status', 'checked')->count();

        if (!$habit->completed && $checkedDaysCount >= $habit->target_days) {
            // Mark habit as completed
            $habit->update(['completed' => true]);

            // Create achievement (only if it doesn't exist)
            Achievement::firstOrCreate(
                ['user_id' => $habit->user_id, 'habit_id' => $habit->id],
                [
                    'name' => 'Completed: ' . $habit->name,
                    'start_date' => $habit->start_date,
                    'completion_date' => Carbon::now()->toDateString(), // Or use the date of the last progress?
                    'target_days' => $habit->target_days,
                    'checked_days_count' => $checkedDaysCount,
                ]
            );
        }
    }

    /**
     * Check habit completion status after progress removal and remove achievement if needed.
     *
     * @param \App\Models\Habit $habit
     * @return void
     */
     protected function checkAndRemoveAchievement(Habit $habit)
     {
        $checkedDaysCount = $habit->progress()->where('status', 'checked')->count();

        if ($habit->completed && $checkedDaysCount < $habit->target_days) {
            // Mark habit as not completed anymore
            $habit->update(['completed' => false]);

            // Remove the associated achievement if it exists
            $habit->achievement()->delete();
        }
        // If it was completed and still meets the criteria, do nothing.
     }
}
