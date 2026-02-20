@extends('layouts.site')

@section('content')
    <!-- Ajuste de margem negativa para o Hero ficar atrás da navbar transparente -->
    <div class="-mt-20"> 
        @include('components.site.hero')
    </div>

    <!-- Inclui outros blocos que compõem a home -->
    @include('components.site.stats')
    @include('components.site.mission')
    @include('components.site.cta')
    @include('components.site.services-list')
@endsection