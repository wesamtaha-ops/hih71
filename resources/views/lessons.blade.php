@extends('layouts.app')

@section('styles')
    <style>
        
    </style>
@endsection

@section('content')
<main class="tu-main tu-bgmain">
    <div class="tu-main-section">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-12">
                    <aside class="tu-asider-holder">
                        <div class="tu-asidebox">
                            <div>
                                <h4 style="width: 100%; padding-bottom: 10px;border-bottom: 1px solid #f1f1f1">Lessons</h4>
                            </div>

                            <table id="table-balance" class="table table-striped" style="margin-top: 10px;">
                                <tr>
                                    <th>@if(isTeacher()) Student @else Teacher @endif</th>
                                    <th>Topic</th>
                                    <th>Time</th>
                                    <th>Link</th>
                                    @if(isTeacher())
                                    <th>Rate</th>
                                    @endif
                                </tr>

                                @foreach($orders as $order)
                                    <tr>
                                        <td>@if(isTeacher()) {{$order->student->name}} @else {{$order->teacher->name}} @endif</td>
                                        <td>{{@$order->topic->name_en}}</td>
                                        <td>{{$order->date}} {{$order->time}}</td>
                                        <td><a href="{{$order->meeting_id}}">Link</td>
                                        @if(isTeacher())
                                        <th><a href="{{route('review.student.add', ['student_id' => $order->student_id] )}}">Rate</a></th>
                                        @endif
                                    </tr>
                                @endforeach

                            </table>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
    <script>
       
    </script>
@endpush