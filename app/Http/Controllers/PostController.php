<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;

class PostController extends Controller
{
    public function index()
    {
        // $posts = Post::with('categories')->get();
        $posts = Post::with('categories')->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        return view('posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {    
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
            
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
        }
        $post = new Post;
        $post->title = $request->title;
        $post->user_id = auth()->id();
        $post->content = $request->content;
        $post->image = $imageName;

        if ($post->save()) {
            
            if ($request->has('category_id')) {
                $post->categories()->attach($request->input('category_id'));
            }
            return redirect('/')->with('success', '投稿が成功しました。');
        } else {
            return redirect()->back()->with('error', '投稿に失敗しました。');
        }
    }

    public function show($id)
    {   
        $post = Post::with('user', 'categories')->findOrFail($id);
        $comments = Comment::where('post_id', $post->id)->get();
        
        return view('posts.show', compact('post', 'comments'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $user = auth()->user();
        $categories = Category::all();

        if($user->id === $post->user_id){
            return view('posts.edit', compact('post', 'categories'));
        }  else {
            return redirect('/');
        }
        
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post->categories()->detach();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
    
            $post->image = $imageName;
        }
    
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->save();
        $post->categories()->attach($request->category);

        return redirect()->route('post.show', ['post' => $post])->with('success', '編集に成功しました');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect('/')->with('success', '投稿が削除されました');
    }

    public function indexByCategory(Category $category)
    {
        $posts = $category->posts;
        $categories = Category::all();
        return view('posts.index', compact('posts', 'categories'));
    }
}
