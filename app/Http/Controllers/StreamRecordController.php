<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\StreamRecordService;
use Illuminate\Validation\ValidationException;

class StreamRecordController extends Controller
{
    protected StreamRecordService $service;

    public function __construct(StreamRecordService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json($this->service->getAll($request), 200);
    }

    public function show($id): JsonResponse
    {
        $record = $this->service->getById($id);
        if (!$record) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        return response()->json($record, 200);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $record = $this->service->create($request->all());
            return response()->json(['message' => 'Record created', 'data' => $record], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $record = $this->service->update($id, $request->all());
            if (!$record) {
                return response()->json(['message' => 'Record not found'], 404);
            }
            return response()->json(['message' => 'Record updated', 'data' => $record], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id): JsonResponse
    {
        if (!$this->service->delete($id)) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        return response()->json(['message' => 'Record deleted'], 200);
    }
}
