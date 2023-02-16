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
                                    <th>Teacher</th>
                                    <th>Topic</th>
                                    <th>Time</th>
                                    <th>Link</th>
                                </tr>

                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{$order->teacher->name}}</td>
                                        <td>{{@$order->topic->name_en}}</td>
                                        <td>{{$order->date}} {{$order->time}}</td>
                                        <td>
                                            @if($order->meeting_id)
                                                <a href="/meeting/{{$order->meeting_id}}">Link
                                            @endif
                                        </td>
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