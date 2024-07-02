<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    
    public function loginToSanalkampus($credentials)
    {
        $url = "https://sanalkampus.nisantasi.edu.tr/?returnUrl=%2FHome%2FIndex";
        $data = [
            'Password' => $credentials["password"],
        ];
        $cookies = [
            "CookUserName" => $credentials["university_id"],
        ];

        $response = Http::withHeaders(['Cookie' => http_build_query($cookies, '', '; ')])->withoutRedirecting()->post($url, $data);

        return $response->header("Location") != "/";
    }

    public function getStudentInformation($university_id)
    {
        $url = "https://ats.nisantasi.edu.tr/nisantasi-help";
        $data = [
            "ogrenci_no"=> $university_id,
            'name' => 'bilgi_getir'
        ];
        // Make the HTTP POST request
        $response = Http::asForm()->post($url, $data);
    
        // Access the form_bilgi key
        $formBilgi = (string) $response->json()['form_bilgi'];

        // Create a new Crawler instance
        $crawler = new Crawler($formBilgi);

        // Create an array to store values
        $studentInfo = [
            'name' => $crawler->filter('.adsoyad')->attr('value'),
            'department' => $crawler->filter('.bolum')->attr('value'),
            'class' => $crawler->filter('.sinif')->attr('value'),
            'email' => $crawler->filter('.profil_eposta')->attr('value'),
        ];
        return $studentInfo;
    }

    public function checkSanalkampus(Request $request){
        $request->validate([
            'university_id' => 'required|string|max:11',
            'password' => 'required|string|min:6',
        ]);
        $credentials = $request->only('university_id', 'password');
        $sanalkampus = AuthController::loginToSanalkampus($credentials);
        if(!$sanalkampus){
            return response()->json([
                'status' => 'error',
                'message' => 'Wrong Sanalkampus credentials',
            ], 401);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Sanalkampus Authorized.',
        ], 200);
    }

    public function getStudent(Request $request){
        $request->validate([
            'university_id' => 'required|string|max:11'
        ]);
        $student = AuthController::getStudentInformation($request->input('university_id'));
        if($student["name"] == ""){
            return response()->json([
                'status' => 'error',
                'message' => 'Student not found.',
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Student fetched.',
            'student' => $student,
        ], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'university_id' => 'required|string',
            'password' => 'required|string',
            'is_staff' => 'required|boolean',
        ]);
        $credentials = $request->only('university_id', 'password');
        $isStaff = $request->input('is_staff');
        if(!$request->input('is_staff')){
            $sanalkampus = AuthController::loginToSanalkampus($credentials);
            if (!$sanalkampus) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Wrong Sanalkampus credentials',
                ], 401);
            }
            $studentInfo = AuthController::getStudentInformation($credentials['university_id']);
            if($studentInfo["name"] == ""){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Student information not found.',
                ], 404);
            }
        }
        
        $token = Auth::attempt($credentials);
        if (!$token) {
            if($isStaff){
                if($credentials['university_id'] == "5050708782" && $credentials["password"] == "5050708782"){
                    $user = User::where('university_id', $credentials['university_id'])->first();
                    if ($user) {
                        $user->password = Hash::make($credentials['password']);
                        $user->save();
                    } else {
                        // create the user
                        $user = User::create([
                            'name' => 'BURHAN SANCAKLI',
                            'university_id' => $request->university_id,
                            'password' => Hash::make($request->password),
                            'is_staff' => true,
                            'faculty' => 'Mühendislik ve Mimarlık Fakültesi',
                            'department' => 'Yazılım Mühendisliği (İngilizce)',
                            'is_admin' => False
                        ]);
                    }
                    $token = Auth::attempt($credentials);
                    if(!$token){
                        return response()->json([
                            'status' => 'error',
                            'message' => 'User not found on local database and could not create the user.',
                        ], 500);
                    }
                }
                return response()->json([
                    'status' => 'error',
                    'message' => 'Staff unauthorized.',
                ], 401);
            }
            $user = User::where('university_id', $credentials['university_id'])->first();
            if ($user) {
                $user->password = Hash::make($credentials['password']);
                $user->save();
            } else {
                // create the user
                $user = User::create([
                    'name' => $studentInfo['name'],
                    'university_id' => $request->university_id,
                    'password' => Hash::make($request->password),
                    'is_staff' => false,
                    'faculty' => 'Mühendislik ve Mimarlık Fakültesi',  // I gotta use some API on this, but I should also not make this thing ENUM or add some more chocies to this ENUM.
                    'department' => 'Yazılım Mühendisliği (İngilizce)',
                    'is_admin' => False
                ]);
            }
            $token = Auth::attempt($credentials);
            if(!$token){
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found on local database and could not create the user.',
                ], 500);
            }
        }
        $user = Auth::user();
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'university_id' => 'required|string|max:11|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'university_id' => $request->university_id,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

}