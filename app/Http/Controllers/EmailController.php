<?php

namespace App\Http\Controllers;

use App\Http\Requests\QueueEmailRequest;
use App\Jobs\SendStudyEmailJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class EmailController extends Controller
{
    public function store(QueueEmailRequest $request): JsonResponse
    {
        $payload = $request->validated();

        Cache::put('study:last_email_payload', [
            'to' => $payload['to'],
            'subject' => $payload['subject'],
            'message' => $payload['message'],
            'queued_at' => now()->toIso8601String(),
        ], now()->addMinutes(30));

        SendStudyEmailJob::dispatch( //aqui dispara o job
            to: $payload['to'],
            subject: $payload['subject'],
            message: $payload['message'],
        )->onQueue('emails');

        return response()->json([
            'queued' => true,
            'queue' => 'emails',
        ], 202);
    }
}
