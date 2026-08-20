@php
    $scripts = ($trackingScripts ?? collect())->get($placement, collect());
@endphp

@foreach($scripts as $trackingScript)
{!! $trackingScript->script_code !!}
@endforeach
