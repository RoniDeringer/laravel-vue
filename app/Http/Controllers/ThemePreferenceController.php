<?php

namespace App\Http\Controllers;

use App\Models\DevicePreference;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ThemePreferenceController extends Controller
{
    private const COOKIE_NAME = 'ms_device';

    private function resolveDeviceId(Request $request): array
    {
        $deviceId = $request->cookie(self::COOKIE_NAME);
        $cookie = null;

        if (! is_string($deviceId) || strlen($deviceId) < 10) {
            $deviceId = (string) Str::uuid();
            $cookie = cookie(self::COOKIE_NAME, $deviceId, 60 * 24 * 365 * 5);
        }

        return [$deviceId, $cookie];
    }

    public function show(Request $request): JsonResponse
    {
        [$deviceId, $cookie] = $this->resolveDeviceId($request);

        $preference = DevicePreference::firstOrCreate(
            ['device_id' => $deviceId],
            ['theme' => 'light'],
        );

        $response = response()->json([
            'device_id' => $deviceId,
            'theme' => $preference->theme,
        ]);

        return $cookie ? $response->withCookie($cookie) : $response;
    }

    public function update(Request $request): JsonResponse
    {
        $data = $request->validate([
            'theme' => ['required', Rule::in(['light', 'dark'])],
        ]);

        [$deviceId, $cookie] = $this->resolveDeviceId($request);

        $preference = DevicePreference::updateOrCreate(
            ['device_id' => $deviceId],
            ['theme' => $data['theme']],
        );

        $response = response()->json([
            'device_id' => $deviceId,
            'theme' => $preference->theme,
        ]);

        return $cookie ? $response->withCookie($cookie) : $response;
    }
}

