@if ($errors->all() != null)
<div class="alert alert-danger" role="alert">
    <h4>Something went wrong</h4>
    @foreach ($errors->all() as $error)
    <div>- {{ $error }}</div>
    @endforeach
</div>
@endif

@if (session('success'))
    <div class="container">
        <div class="success alert-success" role="alert">
            <p><small> {{ session('success') }} </small></p>
        </div>
    </div>
@endif