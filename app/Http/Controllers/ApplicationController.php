<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve all applications
        $applications = Application::all()->sortByDesc('id');

        // Check if the 'is_staff' query parameter is present
        $isStaff = $request->query('is_staff');
        $studentId = $request->query('student_id');
        $showAll = $request->query('show_all');
        $staffId = $request->query("staff_id");

        $formattedApplications = $applications
        ->filter(function ($application) use ($isStaff,$studentId,$showAll) {
            // If isStaff is true, include only the applications with a status of 'evaluating' or 'reevaluating'
            if($isStaff && $showAll){
                return $application->status !== 'evaluating' && $application->status !== 'reevaluating';
            } if($isStaff){
                return $application->status === 'evaluating' || $application->status == 'reevaluating';
            } else if (!$isStaff && $studentId == $application->student_id){
                return True;
            } else if (!$isStaff && !$studentId){
                return True;
            }
            
        })
        ->map(function ($application) {
            // Format each application
            return [
                'id' => $application->id,
                'studentId' => $application->student->id,
                'studentUniversityId' => $application->student->university_id,
                'studentName' => $application->student->name,
                'name' => $application->activity->name,
                'startDate' => $application->created_at,
                'endDate' => $application->updated_at,
                'fileUrl' => $application->file_path,
                'score' => $application->activity->score,
                'status' => $application->status,
                'conclusion' => $application->conclusion,
                'objection' => $application->objection
            ];
        })->values(); // Reindex the collection to ensure it's always a list;

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

    public function downloadFile($id)
    {
        $application = Application::findOrFail($id);

        // Check if the file path exists
        if (Storage::disk('public')->exists($application->file_path)) {
            // If the file exists, create a downloadable response
            return response()->download(storage_path("app/public/{$application->file_path}"));
        } else {
            // If the file does not exist, return an error response
            return response()->json(['error' => 'File not found'], 404);
        }
    }

    // Add other methods as needed
    public function accept(Request $request, $id)
    {
        // Find the application by ID
        $application = Application::find($id);

        // Check if application exists
        if (!$application) {
            return response()->json(['message' => 'Application not found'], 404);
        }

        // Update the status to 'accepted'
        $application->status = 'accepted';
        $application->save();

        return response()->json(['message' => 'Application accepted successfully']);
    }
    public function reject(Request $request, $id)
    {
        // Find the application by ID
        $application = Application::find($id);

        // Check if application exists
        if (!$application) {
            return response()->json(['message' => 'Application not found'], 404);
        }
        if($application->status == 'reevaluating'){
            // Update the status to 'discarded'
            $application->status = 'discarded';
        } else {
            // Update the status to 'rejected'
            $application->status = 'rejected';
        }

        // Update the conclusion if provided in the request
        if ($request->has('conclusion')) {
            $application->conclusion = $request->input('conclusion');
        }

        $application->save();

        return response()->json(['message' => 'Application rejected successfully']);
    }
    public function object(Request $request, $id)
    {
        // Find the application by ID
        $application = Application::find($id);

        // Check if application exists
        if (!$application) {
            return response()->json(['message' => 'Application not found'], 404);
        }
        // Update the status to 'reevaluating'
        $application->status = 'reevaluating';

        // Update the objection if provided in the request
        if ($request->has('objection')) {
            $application->objection = $request->input('objection');
        }

        $application->save();

        return response()->json(['message' => 'Application objected successfully']);
    }
}
