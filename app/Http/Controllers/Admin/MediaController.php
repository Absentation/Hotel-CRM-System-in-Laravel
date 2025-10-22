<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Media\StoreMediaRequest;
use App\Http\Requests\Admin\Media\UpdateMediaRequest;
use App\Models\HotelMedia;
use App\Models\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function index(): View
    {
        $media = HotelMedia::orderBy('display_order')->orderByDesc('created_at')->paginate(20);

        return view('admin.media.index', compact('media'));
    }

    public function create(): View
    {
        $media = new HotelMedia(['is_published' => true]);

        return view('admin.media.create', compact('media'));
    }

    public function store(StoreMediaRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $file = $request->file('file');
        $mime = $file->getMimeType();
        if ($data['media_type'] === 'image' && ! str_starts_with($mime, 'image/')) {
            return back()->withErrors(['file' => 'Uploaded file must be an image for the selected media type.'])->withInput();
        }

        if ($data['media_type'] === 'video' && ! str_starts_with($mime, 'video/')) {
            return back()->withErrors(['file' => 'Uploaded file must be a video for the selected media type.'])->withInput();
        }

        $path = $file->store('media', 'public');
        $thumbnailPath = null;

        if ($request->file('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('media/thumbnails', 'public');
        }

        $media = HotelMedia::create([
            'title' => $data['title'],
            'media_type' => $data['media_type'],
            'file_path' => $path,
            'thumbnail_path' => $thumbnailPath,
            'is_published' => $data['is_published'] ?? true,
            'display_order' => $data['display_order'] ?? 0,
            'description' => $data['description'] ?? null,
        ]);

        $this->logAction('media_created', $media->id, $media->toArray());

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'Media uploaded successfully.');
    }

    public function edit(HotelMedia $medium): View
    {
        return view('admin.media.edit', ['media' => $medium]);
    }

    public function update(UpdateMediaRequest $request, HotelMedia $medium): RedirectResponse
    {
        $data = $request->validated();

        $update = [
            'title' => $data['title'],
            'media_type' => $data['media_type'],
            'is_published' => $data['is_published'] ?? true,
            'display_order' => $data['display_order'] ?? 0,
            'description' => $data['description'] ?? null,
        ];

        if ($request->file('file')) {
            $mime = $request->file('file')->getMimeType();
            if ($data['media_type'] === 'image' && ! str_starts_with($mime, 'image/')) {
                return back()->withErrors(['file' => 'Uploaded file must be an image for the selected media type.'])->withInput();
            }

            if ($data['media_type'] === 'video' && ! str_starts_with($mime, 'video/')) {
                return back()->withErrors(['file' => 'Uploaded file must be a video for the selected media type.'])->withInput();
            }

            if ($medium->file_path) {
                Storage::disk('public')->delete($medium->file_path);
            }
            $update['file_path'] = $request->file('file')->store('media', 'public');
        }

        if ($request->file('thumbnail')) {
            if ($medium->thumbnail_path) {
                Storage::disk('public')->delete($medium->thumbnail_path);
            }
            $update['thumbnail_path'] = $request->file('thumbnail')->store('media/thumbnails', 'public');
        }

        $medium->update($update);

        $this->logAction('media_updated', $medium->id, $medium->toArray());

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'Media updated successfully.');
    }

    public function destroy(HotelMedia $medium): RedirectResponse
    {
        if ($medium->file_path) {
            Storage::disk('public')->delete($medium->file_path);
        }

        if ($medium->thumbnail_path) {
            Storage::disk('public')->delete($medium->thumbnail_path);
        }

        $this->logAction('media_deleted', $medium->id, $medium->toArray());

        $medium->delete();

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'Media removed.');
    }

    protected function logAction(string $type, int $mediaId, array $object = []): void
    {
        Log::create([
            'log_type' => $type,
            'object' => json_encode(['media_id' => $mediaId, ...$object]),
            'detail' => 'admin_action',
            'employee_id' => auth('admin')->id(),
        ]);
    }
}
