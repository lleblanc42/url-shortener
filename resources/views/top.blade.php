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

                @if(!empty($topUrls))
                    <div class="table-responsive">
                        <table id="top-tbl" class="table table-hover">
                            <thead>
                                <tr>
                                    <td>
                                        Shortened URL
                                    </td>
                                    <td>
                                        Source URL
                                    </td>
                                    <td>
                                        NSFW?
                                    </td>
                                    <td>
                                        Visits
                                    </td>
                                    <td>
                                        Created
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topUrls as $url)
                                    <tr>
                                        <td>
                                            <a href="{{ $url->shortened_url }}" target="_blank">{{ $url->shortened_url }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ $url->source_url }}" target="_blank">{{ $url->source_url }}</a>
                                        </td>
                                        <td>
                                            @if($url->nsfw == 1)
                                                Yes
                                            @else
                                                No
                                            @endif
                                        </td>
                                        <td>
                                            {{ $url->visited }}
                                        </td>
                                        <td>
                                            {{ $url->created_at }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('modals')
@endsection

@section('custom-js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#top-tbl').DataTable({
                "pageLength": 100,
                "paging":   false,
            });
        });
    </script>
@endsection