@if (isset($errors) && count($errors) > 0)
    <div class="alert-container p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
@endif

@if (Session::get('success', false))
    <?php $data = Session::get('success'); ?>
    @if (is_array($data))
        @foreach ($data as $msg)
        <div class="alert-container p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            {{ $msg }}
        </div>
        @endforeach
    @else
        <div class="alert-container p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            {{ $data }}
        </div>
    @endif
@endif