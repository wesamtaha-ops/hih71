@extends('layouts.app')

@section('content')
<main class="tu-main tu-bgmain">
        <section class="tu-main-section">
            <div class="container">
                <div class="row gy-4">
                    @include('components.add_review', ['user_id' => $student_id])
                </div>
            </div>
        </section>
	</main>
@endsection
