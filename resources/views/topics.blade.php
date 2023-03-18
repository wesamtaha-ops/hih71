@extends('layouts.app')

@section('content')
<main class="tu-main">
    <section class="tu-main-section">
        <div class="container">
            <div class="row">
                @foreach($topics as $topic)
                <div class="splide__slide">
                    <a class="tu-categories_content" href="{{route('search', ['topic_id' => $topic['id']])}}">
                        <div class="tu-categories_title">
                            <h6>{{$topic['name_' . app()->currentLocale()]}}</h6>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</main>
@endsection