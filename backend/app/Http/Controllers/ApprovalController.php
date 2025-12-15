<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApprovalDecisionRequest;
use App\Http\Resources\ApprovalResource;
use App\Models\Approval;
use App\Models\Document;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ApprovalController extends Controller
{
    public function index(Document $document): JsonResponse
    {
        $approvals = $document->approvals()->with('user')->orderBy('step')->get();

        return response()->json(ApprovalResource::collection($approvals));
    }

    public function store(ApprovalDecisionRequest $request, Document $document): JsonResponse
    {
        if ($document->status !== 'in_review') {
            return response()->json(['message' => 'Document is not awaiting review'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $decision = $document->approvals()->create([
            ...$request->validated(),
            'decided_at' => now(),
        ]);

        if ($request->input('decision') === 'approved') {
            $document->update(['status' => 'approved']);
        } else {
            $document->update(['status' => 'draft']);
        }

        return response()->json(new ApprovalResource($decision), Response::HTTP_CREATED);
    }
}
