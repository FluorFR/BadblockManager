@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="/assets/plugins/magnific-popup/dist/magnific-popup.css"/>
@endsection
@section('content')
    <div class="row">
        <div class="portfolioContainer">
            <div class="row">
                @foreach($Screen as $row)
                    <div class="col-md-2 natural personal">
                        <div class="gal-detail thumb">
                            <a href="https://cdn.badblock.fr/upload/{{ $row['file_name'] }}" class="image-popup" title="Screenshot-1">
                                <img src="https://cdn.badblock.fr/upload/{{ $row['file_name'] }}" class="thumb-img" alt="work-thumbnail">
                            </a>
                            <h5>{{ $row['file_name'] }} - {{ $row['date'] }} - {{ $row['ip'] }}</h5>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
@section('after_scripts')

@endsection
