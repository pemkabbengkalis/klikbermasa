@push('alert')
<div class="alert alert-dismissible alert-{{$type}}">
    <button class="btn-close" type="button" data-bs-dismiss="alert"></button> {!!$message!!}
  </div>
@endpush
