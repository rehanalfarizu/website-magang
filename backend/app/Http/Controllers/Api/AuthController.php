<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\AdminProdi;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register user baru
     */
    public function register(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role'     => 'required|in:mahasiswa,dosen,admin,mitra',
            // Profile fields
            'nama'     => 'required|string|max:255',
            // Mahasiswa
            'nim'      => 'required_if:role,mahasiswa|string|max:20',
            'ipk'      => 'nullable|numeric|min:0|max:4',
            'semester' => 'nullable|integer|min:1|max:14',
            // Dosen
            'nidn'     => 'nullable|string|max:20',
            // Mitra
            'nama_perusahaan' => 'required_if:role,mitra|string|max:255',
            'alamat'          => 'nullable|string',
            'pic_nama'        => 'nullable|string|max:255',
            'pic_email'       => 'nullable|email',
            'pic_telepon'     => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'email'         => $request->email,
            'password_hash' => Hash::make($request->password),
            'role'          => $request->role,
        ]);

        // Buat profil sesuai role
        match ($request->role) {
            'mahasiswa' => Mahasiswa::create([
                'user_id'  => $user->id,
                'nim'      => $request->nim,
                'nama'     => $request->nama,
                'ipk'      => $request->ipk,
                'semester' => $request->semester,
                'no_telepon' => $request->no_telepon,
            ]),
            'dosen' => Dosen::create([
                'user_id'    => $user->id,
                'nidn'       => $request->nidn,
                'nama'       => $request->nama,
                'email'      => $request->email,
                'no_telepon' => $request->no_telepon,
            ]),
            'admin' => AdminProdi::create([
                'user_id' => $user->id,
                'nama'    => $request->nama,
            ]),
            'mitra' => Mitra::create([
                'user_id'          => $user->id,
                'nama_perusahaan'  => $request->nama_perusahaan,
                'alamat'           => $request->alamat,
                'pic_nama'         => $request->pic_nama ?? $request->nama,
                'pic_email'        => $request->pic_email ?? $request->email,
                'pic_telepon'      => $request->pic_telepon,
                'status'           => 'pending',
            ]),
            default => null,
        };

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil',
            'user'    => $user->load($this->getProfileRelation($request->role)),
            'token'   => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    /**
     * Login user
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password_hash)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        // Revoke existing tokens (single session)
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'user'    => $user->load($this->getProfileRelation($user->role)),
            'token'   => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Get authenticated user info
     */
    public function me(Request $request)
    {
        $user = $request->user()->load($this->getProfileRelation($request->user()->role));
        return response()->json(['user' => $user]);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }

    /**
     * Helper: get profile relation name by role
     */
    private function getProfileRelation(string $role): string
    {
        return match ($role) {
            'mahasiswa' => 'mahasiswa',
            'dosen'     => 'dosen',
            'admin'     => 'adminProdi',
            'mitra'     => 'mitra',
            default     => 'mahasiswa',
        };
    }
}
