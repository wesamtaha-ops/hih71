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
                                <h4 style="width: 100%; padding-bottom: 10px;border-bottom: 1px solid #f1f1f1">Packages</h4>

                                <a href="{{route('packages.add')}}">Add New Package</a>
                            </div>

                            <table id="table-balance" class="table table-striped" style="margin-top: 10px;">
                                <tr>
                                    <th>Image</th>    
                                    <th>Title En</th>
                                    <th>Title Ar</th>
                                    <th></th>
                                </tr>

                                @foreach($packages as $package)
                                    <tr>
                                        <td><img src="{{asset('images/'. $package->image)}}" style="width: 200px; height: 200px;object-fit: cover;" /></td>
                                        <td>{{$package->title_en}}</td>
                                        <td>{{$package->title_ar}}</td>
                                        <td><a href="{{route( 'packages.add', ['package' => $package->id] )}}">Details</a></td>
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