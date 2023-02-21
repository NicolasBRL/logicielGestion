@extends('layouts.pagebuilder')

@section('content')
<div id="gjs"></div>

<form id="panel__save-changes" class="panel__save-changes" action="{{route('configuration.pageBuilder.save')}}" method="post">
    @csrf
</form>
@endsection

@section('script')

@if(App\Models\SiteInfo::exist())
<script type="text/javascript">
    const contenueHTML = @json(App\Models\SiteInfo::getContenueHTML());
</script>
@endif

@endsection