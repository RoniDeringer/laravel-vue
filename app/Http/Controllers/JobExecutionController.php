<?php

namespace App\Http\Controllers;

use App\Models\JobExecution;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobExecutionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = JobExecution::query()->latest('id');

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }

        if ($request->filled('queue')) {
            $query->where('queue', $request->string('queue')->toString());
        }

        if ($request->filled('q')) {
            $q = mb_strtolower($request->string('q')->toString());
            $query->where(function ($sub) use ($q) {
                $sub->whereRaw('LOWER(job_id) LIKE ?', ["%{$q}%"])
                    ->orWhereRaw('LOWER(job_name) LIKE ?', ["%{$q}%"])
                    ->orWhereRaw('LOWER(last_error) LIKE ?', ["%{$q}%"]);
            });
        }

        $limit = (int) $request->integer('limit', 200);
        $limit = max(1, min(500, $limit));

        return response()->json([
            'data' => $query->limit($limit)->get([
                'id',
                'job_id',
                'job_name',
                'connection',
                'queue',
                'status',
                'attempts',
                'started_at',
                'finished_at',
                'duration_ms',
                'last_error',
                'created_at',
                'updated_at',
            ]),
        ]);
    }

    public function show(JobExecution $jobExecution): JsonResponse
    {
        return response()->json([
            'data' => $jobExecution->only([
                'id',
                'job_id',
                'job_name',
                'connection',
                'queue',
                'status',
                'attempts',
                'started_at',
                'finished_at',
                'duration_ms',
                'last_error',
                'exception_class',
                'exception_trace',
                'log',
                'payload',
                'meta',
                'created_at',
                'updated_at',
            ]),
        ]);
    }
}

