@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('forms.shorten')

                <p class="text-center">
                    <a href="{{ $url }}" target="_blank">{{ $url }}</a>
                </p>
            </div>
        </div>
    </div>
@endsection