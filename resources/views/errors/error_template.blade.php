<?php $error = json_decode($exception->getMessage(), true); ?>
@foreach ($error as $key => $value)
    <p>{{ $key }} : {{ $value  }} </p>
@endforeach
