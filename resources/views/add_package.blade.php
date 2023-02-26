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
                                <h4 style="width: 100%; padding-bottom: 10px;border-bottom: 1px solid #f1f1f1">Add Package</h4>
                            </div>

                            <form action="{{route('package.update')}}" method="post" id="frm_add_package" enctype="multipart/form-data"  onsubmit="validate(event)">
                                <input type="hidden" name="package_id" value="{{@$package->id}}" />

                                @include('components.standard.inputtext', ['id' => 'title_en', 'name' => 'title_en', 'placeholder' => 'Title English', 'value' => @$package->title_en, 'required' => true])
                                @include('components.standard.inputtext', ['id' => 'title_ar', 'name' => 'title_ar', 'placeholder' => 'Title Arabic', 'value' => @$package->title_ar, 'required' => true])

                                @include('components.standard.textarea', ['id' => 'description_en', 'name' => 'description_en', 'placeholder' => 'Description English', 'value' => @$package->description_en, 'required' => true])
                                @include('components.standard.textarea', ['id' => 'description_ar', 'name' => 'description_ar', 'placeholder' => 'Description Arabic', 'value' => @$package->description_en, 'required' => true])

                                @include('components.standard.select', ['id' => 'currency', 'name' => 'currency_id', 'placeholder' => __('app.select_how_many_currency'), 'options' => session()->get('currencies'), 'value' => @$package->currency_id, 'required' => true])
                                @include('components.standard.inputtext', ['id' => 'fees', 'name' => 'fees', 'placeholder' => 'fees', 'value' => @$package->fees, 'required' => true])

                                @csrf

                                <input type="file" name="image" required />
                                
                                <button id="btn_submit" class="btn btn-primary">Submit</button>
                            </form>
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
        $('#btn_submit').click(function () {
            $('#frm_add_package').submit();
        })
    </script>
@endpush