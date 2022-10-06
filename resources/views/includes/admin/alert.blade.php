@if(session('message'))
  <div class="container">
  <div class="alert alert-{{session('type') ?? 'info' }}">
      {{ session('message') }}
  </div>
  </div>
@endif