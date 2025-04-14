<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('author')->latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'published_at' => 'nullable|date'
        ]);

        $validated['author_id'] = Auth::id();
        $validated['is_published'] = $request->input('action') === 'publish';
        
        if ($validated['is_published'] && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        News::create($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'News article ' . ($validated['is_published'] ? 'published' : 'saved as draft') . ' successfully');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', ['article' => $news]);
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'published_at' => 'nullable|date'
        ]);

        $isPublishing = $request->input('action') === 'publish' && !$news->is_published;
        $validated['is_published'] = $request->input('action') === 'publish';

        if ($isPublishing && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'News article updated successfully');
    }

    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('admin.news.index')
            ->with('success', 'News article deleted successfully');
    }

    public function publish(News $news)
    {
        $news->update([
            'is_published' => true,
            'published_at' => $news->published_at ?? now()
        ]);

        return redirect()->route('admin.news.index')
            ->with('success', 'News article published successfully');
    }

    public function unpublish(News $news)
    {
        $news->update([
            'is_published' => false
        ]);

        return redirect()->route('admin.news.index')
            ->with('success', 'News article unpublished successfully');
    }
}
