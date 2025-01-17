@include('backend.layout.header')
@include('backend.layout.sidebar')
<main class="app-content" style="background:#f8f5f5">
    <div class="app-title " >
      <div>
        <h1><i class="bi bi-"></i> {{ config('menu.active.name') ?? 'Untitled' }}</h1>
        <p><i class="bi bi-info-square"></i>  {{ config('menu.active.description')?? 'Untitled' }}</p>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="bi bi-house-door fs-6"></i> </a></li>

        <li class="breadcrumb-item">{{ config('menu.active.name') ?? 'Untitled' }}</li>

      </ul>
    </div>
    @if(Session::has('danger'))
    <div class="alert alert-dismissible alert-danger">
        <button class="btn-close" type="button" data-bs-dismiss="alert"></button> {!!Session::get('danger')!!}
      </div>
    @endif
    @if(Session::has('success'))
    <div class="alert alert-dismissible alert-success">
        <button class="btn-close" type="button" data-bs-dismiss="alert"></button> {!!Session::get('success')!!}
      </div>
    @endif
    <div class="alert alert-dismissible alert-success" style="display: none">
        <button class="btn-close" type="button" data-bs-dismiss="alert"></button> <span></span>
    </div>
    <div class="alert alert-dismissible alert-danger" style="display: none">
        <button class="btn-close" type="button" data-bs-dismiss="alert"></button> <span></span>
    </div>
    @if(Session::has('warning'))
    <div class="alert alert-dismissible alert-warning">
        <button class="btn-close" type="button" data-bs-dismiss="alert"></button> {!!Session::get('warning')!!}
      </div>
    @endif
    @if(Session::has('info'))
    <div class="alert alert-dismissible alert-info">
        <button class="btn-close" type="button" data-bs-dismiss="alert"></button> {!!Session::get('info')!!}
      </div>
    @endif


    @if ($errors->any())
    <div class="alert alert-dismissible alert-danger">
        <button class="btn-close" type="button" data-bs-dismiss="alert"></button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@stack('alert')
    @yield('content')
  </main>
  @include('backend.layout.footer')
