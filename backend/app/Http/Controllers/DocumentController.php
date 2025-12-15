<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class DocumentController extends Controller
{
    public function index(): JsonResponse
    {
        $documents = Document::query()
            ->with(['template', 'owner'])
            ->latest()
            ->paginate();

        return response()->json(DocumentResource::collection($documents));
    }

    public function store(StoreDocumentRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['owner_id'] = $request->user()?->id;
        $data['status'] = 'draft';
        $data['version'] = $data['version'] ?? 'v1.0';

        $document = Document::create($data);

        return response()->json(new DocumentResource($document), Response::HTTP_CREATED);
    }

    public function show(Document $document): JsonResponse
    {
        $document->load(['template', 'owner', 'approvals']);

        return response()->json(new DocumentResource($document));
    }

    public function update(UpdateDocumentRequest $request, Document $document): JsonResponse
    {
        $document->update($request->validated());

        return response()->json(new DocumentResource($document));
    }

    public function destroy(Document $document): JsonResponse
    {
        $document->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function submit(Document $document): JsonResponse
    {
        if ($document->status !== 'draft') {
            return response()->json(['message' => 'Only drafts can be submitted'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $document->update(['status' => 'in_review']);

        return response()->json(new DocumentResource($document));
    }

    public function publish(Document $document): JsonResponse
    {
        if ($document->status !== 'approved') {
            return response()->json(['message' => 'Only approved documents can be published'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $document->update([
            'status' => 'published',
            'published_at' => Carbon::now(),
        ]);

        return response()->json(new DocumentResource($document));
    }
}
