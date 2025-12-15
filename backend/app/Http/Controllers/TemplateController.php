<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTemplateRequest;
use App\Http\Requests\UpdateTemplateRequest;
use App\Http\Resources\TemplateResource;
use App\Models\Template;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TemplateController extends Controller
{
    public function index(): JsonResponse
    {
        $templates = Template::query()->latest()->paginate();

        return response()->json(TemplateResource::collection($templates));
    }

    public function store(StoreTemplateRequest $request): JsonResponse
    {
        $template = Template::create($request->validated());

        return response()->json(new TemplateResource($template), Response::HTTP_CREATED);
    }

    public function show(Template $template): JsonResponse
    {
        return response()->json(new TemplateResource($template));
    }

    public function update(UpdateTemplateRequest $request, Template $template): JsonResponse
    {
        $template->update($request->validated());

        return response()->json(new TemplateResource($template));
    }

    public function destroy(Template $template): JsonResponse
    {
        $template->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
