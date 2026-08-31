<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ResidentAuthController extends Controller
{
    public function redirectToGoogle()
    {
        $clientId = config('services.google.client_id');

        if (! $clientId) {
            return redirect('/login')->withErrors([
                'resident_login' => 'Google todavia no esta configurado para residentes.',
            ]);
        }

        session(['google_oauth_state' => Str::random(40)]);

        $query = http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => config('services.google.redirect'),
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => session('google_oauth_state'),
            'access_type' => 'online',
            'prompt' => 'select_account',
        ]);

        return redirect('https://accounts.google.com/o/oauth2/v2/auth?'.$query);
    }

    public function handleGoogleCallback(Request $request)
    {
        if ($request->get('state') !== session('google_oauth_state')) {
            return redirect('/login')->withErrors([
                'resident_login' => 'La sesion de Google expiro. Intenta nuevamente.',
            ]);
        }

        if (! $request->get('code')) {
            return redirect('/login')->withErrors([
                'resident_login' => 'Google no devolvio un codigo valido.',
            ]);
        }

        try {
            $client = new Client(['timeout' => 15]);

            $tokenResponse = $client->post('https://oauth2.googleapis.com/token', [
                'form_params' => [
                    'client_id' => config('services.google.client_id'),
                    'client_secret' => config('services.google.client_secret'),
                    'redirect_uri' => config('services.google.redirect'),
                    'grant_type' => 'authorization_code',
                    'code' => $request->get('code'),
                ],
            ]);

            $tokenData = json_decode((string) $tokenResponse->getBody(), true);

            $profileResponse = $client->get('https://www.googleapis.com/oauth2/v3/userinfo', [
                'headers' => [
                    'Authorization' => 'Bearer '.$tokenData['access_token'],
                ],
            ]);

            $profile = json_decode((string) $profileResponse->getBody(), true);
        } catch (\Throwable $e) {
            return redirect('/login')->withErrors([
                'resident_login' => 'No se pudo iniciar sesion con Google.',
            ]);
        }

        $email = $profile['email'] ?? null;

        if (! $email) {
            return redirect('/login')->withErrors([
                'resident_login' => 'Tu cuenta de Google no devolvio un correo valido.',
            ]);
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            $user = User::create($this->residentUserData([
                'name' => $profile['name'] ?? 'Residente',
                'email' => $email,
                'rol' => 'residente',
                'estado' => 'Activo',
                'email_verified_at' => now(),
                'password' => Hash::make(Str::random(40)),
                'ocupacion' => '',
                'path' => '',
            ], $profile['sub'] ?? null, 'google'));
        } else {
            $this->syncProviderData($user, $profile['sub'] ?? null, 'google');
        }

        Auth::login($user, true);

        return redirect('/dashboard');
    }

    public function loginWithCode(Request $request)
    {
        $request->validate([
            'resident_code' => ['required', 'string', 'max:40'],
        ]);

        $code = Str::upper(trim($request->resident_code));

        $accessCode = DB::table('resident_access_codes')
            ->where('code', $code)
            ->where('status', 'Activo')
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            })
            ->first();

        if (! $accessCode) {
            return redirect('/login')->withErrors([
                'resident_login' => 'El codigo ingresado no existe o ya no esta activo.',
            ]);
        }

        $user = null;

        if ($accessCode->user_id) {
            $user = User::find($accessCode->user_id);
        }

        if (! $user) {
            $user = User::create($this->residentUserData([
                'name' => $accessCode->name ?: 'Residente '.$accessCode->code,
                'email' => 'codigo.'.Str::lower($accessCode->code).'@residentes.local',
                'ci' => $accessCode->ci ?: null,
                'rol' => 'residente',
                'estado' => 'Activo',
                'email_verified_at' => now(),
                'password' => Hash::make(Str::random(40)),
                'ocupacion' => '',
                'path' => '',
            ], null, 'code'));

            DB::table('resident_access_codes')
                ->where('id', $accessCode->id)
                ->update([
                    'user_id' => $user->id,
                    'updated_at' => now(),
                ]);
        }

        DB::table('resident_department_access')
            ->where('access_code_id', $accessCode->id)
            ->whereNull('user_id')
            ->update([
                'user_id' => $user->id,
                'updated_at' => now(),
            ]);

        Auth::login($user, true);

        return redirect('/dashboard');
    }

    public function loginWithFirebase(Request $request)
    {
        $request->validate([
            'firebase_token' => ['required', 'string'],
        ]);

        try {
            $client = new Client(['timeout' => 15]);

            $response = $client->post('https://identitytoolkit.googleapis.com/v1/accounts:lookup', [
                'query' => [
                    'key' => config('services.firebase.api_key'),
                ],
                'json' => [
                    'idToken' => $request->firebase_token,
                ],
            ]);

            $payload = json_decode((string) $response->getBody(), true);
            $firebaseUser = $payload['users'][0] ?? null;
        } catch (\Throwable $e) {
            return redirect('/login')->withErrors([
                'resident_login' => 'No se pudo validar tu cuenta de Google.',
            ]);
        }

        if (! $firebaseUser || ($firebaseUser['email'] ?? null) === null) {
            return redirect('/login')->withErrors([
                'resident_login' => 'Firebase no devolvio un correo valido.',
            ]);
        }

        $email = $firebaseUser['email'];
        $googleId = $firebaseUser['localId'] ?? null;
        $displayName = $firebaseUser['displayName'] ?? 'Residente';

        $user = User::where('email', $email)->first();

        if (! $user) {
            $user = User::create($this->residentUserData([
                'name' => $displayName,
                'email' => $email,
                'rol' => 'residente',
                'estado' => 'Activo',
                'email_verified_at' => now(),
                'password' => Hash::make(Str::random(40)),
                'ocupacion' => '',
                'path' => '',
            ], $googleId, 'firebase'));
        } else {
            $this->syncProviderData($user, $googleId, 'firebase');
        }

        Auth::login($user, true);

        return redirect('/dashboard');
    }

    private function residentUserData(array $data, ?string $googleId, string $provider): array
    {
        if ($googleId && $this->usersTableHasColumn('google_id')) {
            $data['google_id'] = $googleId;
        }

        if ($this->usersTableHasColumn('provider')) {
            $data['provider'] = $provider;
        }

        return $data;
    }

    private function syncProviderData(User $user, ?string $googleId, string $provider): void
    {
        $updates = [];
        $attributes = $user->getAttributes();

        if ($googleId && $this->usersTableHasColumn('google_id') && empty($attributes['google_id'])) {
            $updates['google_id'] = $googleId;
        }

        if ($this->usersTableHasColumn('provider') && empty($attributes['provider'])) {
            $updates['provider'] = $provider;
        }

        if ($updates !== []) {
            $user->forceFill($updates)->save();
        }
    }

    private function usersTableHasColumn(string $column): bool
    {
        static $columns = [];

        if (! array_key_exists($column, $columns)) {
            $columns[$column] = Schema::hasColumn('users', $column);
        }

        return $columns[$column];
    }
}
