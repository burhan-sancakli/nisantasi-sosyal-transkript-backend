<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the activities.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = Activity::whereNull('parent_id')  // Fetch only top-level activities
        ->with('children')  // Eager load the children
        ->get()
        ->map(function ($activity) {
            return [
                'id' => $activity->id,
                'name' => $activity->name,
                'children' => $activity->children->map(function ($child) {
                    return [
                        'id' => $child->id,
                        'name' => $child->name,
                        'points' => $child->score  // Assuming 'points' should map to 'score'
                    ];
                }),
            ];
        });

        return response()->json($activities);
    }

    // Other methods for handling requests like creating, showing, updating, and deleting activities
    // ...

}
