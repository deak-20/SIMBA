<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Mahasiswa;

class AuthController extends Controller
{
        public function showLoginForm()
        {
                return view('auth.login');
        }

        public function login(Request $request)
        {
            // Validate input
            $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);
        
            // Find the user by username
            $user = User::where('username', $request->username)->first();
            if (!$user) {
                return redirect()->route('login')->withErrors(['login' => 'Nama pengguna tidak valid.']);
            }
        
            // Log password details for debugging
            Log::info('Input Password:', ['input' => $request->password]);
            Log::info('Hashed Password in DB:', ['hashed' => $user->password]);
        
            // Check if the password matches
            if ($user && Hash::check($request->password, $user->password)) {
                Log::info('Password match');
                Log::info('Login berhasil untuk user:', ['username' => $user->username, 'role' => $user->role]);
        
                $apiToken = null; // fallback value if API call fails
                $data = null;     // variable to hold API response
        
                // Attempt API authentication call
                try {
                    Log::info('Mengirim permintaan API eksternal...');
                    $client = new \GuzzleHttp\Client(['verify' => false]);
        
                    $response = $client->post('https://cis-dev.del.ac.id/api/jwt-api/do-auth', [
                        'form_params' => [
                            'username' => 'johannes', // Use the logged-in user's username if applicable
                            'password' => 'Del@2022',  // Use the provided password if needed
                        ],
                        'headers' => [
                            'Accept' => 'application/json',
                        ],
                        'stream' => true,
                        'timeout' => 60,
                    ]);
        
                    $body = $response->getBody()->getContents();
                    Log::info('Respons API diterima (mentah):', ['response_raw' => $body]);
        
                    $data = json_decode($body, true);
                    Log::info('Respons API setelah diuraikan:', ['parsed_response' => $data]);
                    if ($data && isset($data['result']) && $data['result'] === true) {
                        $apiToken = $data['token'];
                        Log::info('Token API diterima:', ['token' => $apiToken]);
                    } else {
                        Log::error('API login gagal, response tidak valid, melanjutkan dengan login lokal', ['response_parsed' => $data]);
                    }
                } catch (\Exception $e) {
                    Log::error('API Error, melanjutkan dengan login lokal:', ['message' => $e->getMessage()]);
                }
        
                // Fetch nim based on user role
                $nim = null;
                if ($user->role === 'mahasiswa') {
                    $mahasiswa = Mahasiswa::where('username', $user->username)->first();
                    $nim = $mahasiswa ? $mahasiswa->nim : null;
                } else if ($user->role === 'orang_tua') {
                    $nim = $user->orangTua?->nim;
                }
        
                // Store API token (if available) and user data in the session
                session([
                    'api_token' => $apiToken,
                    'user_api' => $data['user'] ?? null,
                    'user' => [
                        'username' => $user->username,
                        'role' => $user->role,
                        'nim' => $nim,
                    ],
                ]);

                // Redirect based on the user's role
                switch ($user->role) {
                    case 'mahasiswa':
                        Log::info('Redirecting to mahasiswa route...');
                        return redirect()->route('beranda')->with('success', 'Login sebagai mahasiswa berhasil!');
        
                    case 'dosen':
                        Log::info('Redirecting to dosen route...');
                        return redirect()->route('dosen')->with('success', 'Login sebagai dosen berhasil!');
        
                    case 'keasramaan':
                        Log::info('Redirecting to keasramaan route...');
                        return redirect()->route('keasramaan')->with('success', 'Login sebagai keasramaan berhasil!');
        
                    case 'orang_tua':
                        Log::info('Redirecting to orang_tua route...');
                        return redirect()->route('orang_tua')->with('success', 'Login sebagai orang tua berhasil!');
        
                    case 'kemahasiswaan':
                        Log::info('Redirecting to kemahasiswaan route...');
                        return redirect()->route('kemahasiswaan_beranda')->with('success', 'Login sebagai kemahasiswaan berhasil!');
        
                    case 'konselor':
                        Log::info('Redirecting to konselor route...');
                        return redirect()->route('konselor_beranda')->with('success', 'Login sebagai konselor berhasil!');
        
                    default:
                        Log::warning('Unknown role detected:', ['role' => $user->role]);
                        return back()->withErrors(['login' => 'Role tidak dikenali.']);
                }
            }
        
            // If authentication fails
            return back()->withErrors(['login2' => 'Password salah.']);
        }
        

        public function logout()
        {
                session()->flush(); // Clear all session data
                session()->regenerate(); // Regenerate session ID for security
                session()->flush();
                session()->regenerate();
                return redirect()->route('login');
        }

}