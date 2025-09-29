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
        $posts = Post::all();

        return view('post.index', ['posts' => $posts]);
    }
    public function create()
    {
        return view('post.create');
    }
    public function store(Request $request)
    {

        $validated = $request->validate([
            'text' => 'required|max:255',
            'order_id' => 'required|integer',
            'product_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        $orderId = $request->input('order_id');
        $order = Order::find($orderId);

        if ($order && $order->status == 'Completed') {
            $newPost = Post::with('order')->where('order_id', $request->order_id)->where('product_id', $request->product_id)->first();

            if (!is_null($newPost)) {

                return redirect()->back()->withErrors('review was created!');
            } else {
                $newPost = Post::create($validated);
            }

            return redirect()->back()->with('success', 'You review has been created');
        } else {
            return redirect()->back()->withErrors('You can leave a review only after order is completed!');
        }
    }
    public function edit(Post $post)
    {
        return view('post.edit', ['post' => $post]);
    }
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'text' => 'required|max:255',

        ]);

        $post->update([
            'text' => $validated['text'],
        ]);

        return redirect()->back()->with('success', 'Post updated successfully');
    }
    public function destroy(Post $post)
    {

        $post->delete();
        return redirect()->route('home')->with('success', 'Post deleted successfully');
    }
}
