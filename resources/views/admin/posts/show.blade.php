@extends('layouts.app')

@section('content')
<div class="container">
   <header>
       <h1>{{$post->title}}</h1>    
   </header>
   <div class="clearfix">
      @if($post->image)
      <img class="float-left mr-2" src="{{$post->image}}" alt="{{$post->slug}}"> 
      @endif
      <p><strong>Categoria:</strong>
           @if($post->category)
           {{$post->category->label}}
           @else
           Nessuna
           @endif
      </p>
      <p>{{$post->content}}</p>
   <div>
       <time>Creato il: {{$post->created_at}}</time>
   </div>
   <div>
       <time>Modificato il: {{$post->updated_at}}</time>
   </div>
   </div>
   <hr>
   <footer class="d-flex align-items-center justify-content-between">
    <div>
        <a href="{{route('admin.posts.index')}}" class="btn btn-secondary">
            <i class=" fa-solid fa-rotate-left mr-2"></i>indietro
        </a>
    </div>
    <div class="d-flex align-items-center justify-content-end">
         <a class="btn btn-warning ml-2 mr-2" href="{{route('admin.posts.edit', $post)}}">
             <i class="fa-solid fa-pencil mr-2"></i>modifica
         </a>
         <form action="{{ route('admin.posts.destroy', $post->id ) }}" method="POST" class="delete-form">
            @csrf
            @method('DELETE')
             <button class="btn btn-danger" type="submit">
                 <i class="fa-solid fa-trash mr-2"></i>Elimina
             </button>
         </form>
    </div>
   </footer>
</div>
@endsection