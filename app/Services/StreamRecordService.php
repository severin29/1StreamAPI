<?php

namespace App\Services;

use App\Models\StreamRecord;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StreamRecordService
{
    public function getAll(Request $request)
    {
        $query = StreamRecord::query();

        if ($request->has('title')) {
            $query->whereRaw('LOWER(title) LIKE ?', ['%' . strtolower($request->input('title')) . '%']);
        }

        if ($request->has('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->has('min_price')) {
            $query->where('tokens_price', '>=', $request->input('min_price'));
        }

        if ($request->has('max_price')) {
            $query->where('tokens_price', '<=', $request->input('max_price'));
        }

        if ($request->has('expires_before')) {
            $query->where('date_expiration', '<=', $request->input('expires_before'));
        }
        if ($request->has('expires_after')) {
            $query->where('date_expiration', '>=', $request->input('expires_after'));
        }

        if ($request->has('sort_by') && in_array($request->input('sort_by'), ['tokens_price', 'date_expiration'])) {
            $direction = $request->input('sort_order', 'asc'); 
            $query->orderBy($request->input('sort_by'), $direction);
        }

        return $query->paginate($request->input('per_page', 10));
    }


    public function getById($id): ?StreamRecord
    {
        return StreamRecord::find($id);
    }

    public function create(array $data): StreamRecord
    {
        $validatedData = $this->validateData($data);

        return StreamRecord::create($validatedData);
    }

    public function update($id, array $data): ?StreamRecord
    {
        $record = StreamRecord::find($id);
        if (!$record) {
            return null;
        }

        $validatedData = $this->validateData($data, true);
        $record->update($validatedData);

        return $record;
    }

    public function delete($id): bool
    {
        $record = StreamRecord::find($id);
        return $record ? $record->delete() : false;
    }

    private function validateData(array $data, bool $isUpdate = false): array
    {
        $rules = [
            'title' => ($isUpdate ? 'sometimes' : 'required') . '|string|max:255',
            'description' => 'nullable|string',
            'tokens_price' => ($isUpdate ? 'sometimes' : 'required') . '|integer',
            'type' => 'nullable|exists:stream_types,id',
            'date_expiration' => ($isUpdate ? 'sometimes' : 'required') . '|date',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
