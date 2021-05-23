@extends('layouts.app')

@section('custom-styles')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if(!empty($error))
                    <div class="alert alert-danger" role="alert">
                        {{ $error }}
                    </div>
                @endif

                <h1 class="text-center">Redirecting to {{ $redirect_url }}...</h1>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="nsfwModal" tabindex="-1" role="dialog" aria-labelledby="nsfwModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nsfwModalLabel">NSFW!!</h5>
                </div>

                <div class="modal-body">
                    The webpage you're about to be redirected to is marked as NSFW. You will be redirected as normal in 10 seconds...
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    @if($nsfw == 1)
        <script type="text/javascript">
            $(document).ready(function () {
                $('#nsfwModal').modal('show');

                setTimeout(function(){ window.location = "{{ $redirect_url }}"; }, 10000);
            });
        </script>
    @endif
@endsection