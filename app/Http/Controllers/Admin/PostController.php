<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\PostPubblicationMail;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('updated_at', 'DESC')->orderBy('created_at', 'DESC')->get();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $post = new Post();
       $categories = Category::all();
       $tags = Tag::select('id','label')->get();
        return view('admin.posts.create', compact('post', 'categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=> 'required|string|unique:posts',
            'content'=> 'required|string',
            'image'=> 'nullable|image|mimes:jpeg,jpg,png',
            'category_id'=> 'nullable|exists:categories,id',
            'tags'=> 'nullable|exists:tags,id'
        ],
        
        [
            'title.required'=> 'Il titolo è obbligatorio',
            'content.required'=> 'Devi scrivere il contenuto del post',
            'title.unique'=> 'Esiste già un post dal titolo $request->title',
            'image.image'=> 'Il file caricato non è di tipo immagine',
            'image.mimes'=> 'Sono ammesse solo immagini di formato: .jpeg, .jpg, .png',
            'category_id.exists'=>'Non esiste una categoria associabile',
            'tags.exists'=>'Uno dei dati indicati non è valido'
        ]);

        $data = $request->all();

        $post = new Post();

        $post-> fill($data);

        $post-> slug = Str::slug($post->title, '-');

        if(array_key_exists('image', $data)){
            $image_url = Storage::put('posts', $data['image']);
            $post->image = $image_url;
        }

        $post->save();

        
        if(array_key_exists('tags',$data)){
            $post->tags()->attach($data['tags']);
        }
       

        return redirect()->route('admin.posts.show', $post)
               ->with('message', 'Post creato con successo')
               ->with('type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {   

        $request->validate([
            'title'=> 'required|string|unique:posts',
            'content'=> 'required|string',
            'image'=> 'nullable|image|mimes:jpeg,jpg,png',
            'category_id'=> 'nullable|exists:categories,id',
            'tags'=> 'nullable|exists:tags,id'
        ],
        
        [
            'title.required'=> 'Il titolo è obbligatorio',
            'content.required'=> 'Devi scrivere il contenuto del post',
            'title.unique'=> 'Esiste già un post dal titolo $request->title',
            'image.image'=> 'Il file caricato non è di tipo immagine',
            'image.mimes'=> 'Sono ammesse solo immagini di formato: .jpeg, .jpg, .png',
            'category_id.exists'=>'Non esiste una categoria associabile',
            'tags.exists'=>'Uno dei dati indicati non è valido'
        ]);


        $data = $request->all();

     
        $data['slug'] = Str::slug($data['title'], '-');

        if(array_key_exists('image', $data)){
            if($post->image) Storage::delete($post->image);
            $image_url = Storage::put('posts', $data['image']);
            $post->image = $image_url;
        }

        $post-> update($data);

        return redirect()->route('admin.posts.show', $post)
               ->with('message', 'Post modificato con successo')
               ->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {   

        if($post->image) Storage::delete($post->image);
        $post->delete();

        return redirect()->route('admin.posts.index')
        ->with('message', 'il post è stato eliminato con successo')
        ->with('type', 'danger');
    }
}
