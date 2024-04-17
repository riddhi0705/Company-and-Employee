@if(session()->has('message'))
    <div class="alert alert-{{ session('type') ?? 'info' }}" role="alert">
        {{ session('message') }}
    </div>
@endif
