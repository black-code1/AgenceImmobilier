@extends('base')

@section('content')

    <x-weather></x-weather>

    <div class="bg-light p-5 mb-5 text-center">
        <div class="container">
            <h1>Agence lorem ipsum</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A amet dignissimos exercitationem facilis itaque minima perspiciatis quidem sunt? Iste, labore?</p>
        </div>
    </div>

    <div class="container">
        <h2>Nos derniers biens</h2>
        <div class="row">
            @foreach($properties as $property)
                <div class="col">
                    @include('property.card')
                </div>
            @endforeach
        </div>
    </div>
@endsection
