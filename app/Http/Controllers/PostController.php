<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class PostController extends Controller
{
    public function index()
    {
        if (Gate::denies('admin-role')) {
            abort(403);
        }

        $posts = Post::with(['user', 'product'])->latest()->paginate(15);

        return view('post.index', compact('posts'));
    }
    public function update(Request $request, $id)
{
    $post = Post::findOrFail($id);
    $validated = $request->validate(['text' => 'required|max:255']);
    $post->update(['text' => $validated['text']]);

    if ($request->ajax()) {
        return response()->json(['success' => true]);
    }
    return redirect()->back()->with('success', 'Post updated successfully');
}

public function destroy($id) 
{
    // 1. Шукаємо пост по ID вручну
    $post = Post::find($id);

    // 2. Якщо пост знайдено — видаляємо
    if ($post) {
        $post->delete();
        
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
    }

   
    if (request()->ajax()) {
        return response()->json(['success' => false, 'message' => 'Post not found'], 404);
    }

    return redirect()->back()->with('success', 'Post deleted successfully');
}
}
