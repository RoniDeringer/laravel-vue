<?php

namespace App\Http\Controllers;

use App\Http\Requests\QueueEmailRequest;
use App\Jobs\SendStudyEmailJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Throwable;

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

        try {
            SendStudyEmailJob::dispatch( //aqui salva o job na fila
                to: $payload['to'],
                subject: $payload['subject'],
                message: $payload['message'],
            )->onQueue('emails');
        } catch (Throwable $e) {
            return response()->json([
                'queued' => false,
                'queue' => 'emails',
                'message' => 'Falha ao enfileirar o email.',
                'error' => $e->getMessage(),
                'exception' => config('app.debug') ? get_class($e) : null,
            ], 500);
        }

        return response()->json([
            'queued' => true,
            'queue' => 'emails',
        ], 202);
    }
}
