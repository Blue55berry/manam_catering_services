<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of published blogs.
     */
    public function index()
    {
        $blogs = Blog::published()->paginate(9);
        return view('blog', compact('blogs'));
    }

    /**
     * Display the specified blog post.
     */
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->published()->firstOrFail();
        return view('blog-detail', compact('blog'));
    }
}
