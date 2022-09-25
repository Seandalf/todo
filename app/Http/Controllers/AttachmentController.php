<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Attachment;
use App\Http\Requests\StoreAttachmentRequest;
use App\Http\Requests\UpdateAttachmentRequest;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return successResponse(
                Attachment::whereUserId($this->user->id)->get()
            );
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), "Could not retrieve attachments for user: {$this->user->id}");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAttachmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttachmentRequest $request)
    {
        try {
            if (!$request->file('attachment')) {
                throw new Exception('No attachment uploaded');
            }

            $file = $request->file('attachment');
            $filename = "{$file->hashName()}.{$file->extension()}";

            $file->storeAs('attachments', $filename);

            $attachment = Attachment::create([
                'name' => $file->getClientOriginalName(),
                'extension' => $file->extension(),
                'filename' => $filename,
                'filepath' => 'attachments',
                'model' => $request->model,
                'model_id' => $request->model_id,
                'user_id' => $this->user->id,
            ]);

            return successResponse($attachment);
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), "Could not upload attachment for user: {$this->user->id}");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function show(Attachment $attachment)
    {
        try {
            return successResponse($attachment);
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), "Could not retrieve attachment: {$attachment->id}");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attachment $attachment)
    {
        try {
            $attachment->delete();
            return successResponse($attachment);
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), "Could not delete attachment: {$attachment->id}");
        }
    }
}
