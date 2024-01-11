<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        // Retrieve all applications and format the response as needed
        $applications = Application::all();

        $formattedApplications = $applications->map(function ($application) {
            return [
                'id' => $application->id,
                'name' => $application->activity->name,
                'startDate' => $application->created_at,
                'endDate' => $application->updated_at,
                'fileUrl' => $application->file_path,
                'status' => ucfirst($application->status), // Capitalize the status
                'score' => $application->activity->score
            ];
        });

        return response()->json($formattedApplications);
    }
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'student_id' => 'required|exists:users,id',
            'staff_id' => 'nullable|exists:users,id',
            'activity_id' => 'required|exists:activities,id',
            'file' => 'required|file',
            // Add more validation as needed
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('applications', 'public');
            $validatedData['file_path'] = $filePath;
        }

        // Set initial status
        $validatedData['status'] = 'evaluating';

        $application = Application::create($validatedData);

        return response()->json($application, 201);
    }

    // Add other methods as needed
}
