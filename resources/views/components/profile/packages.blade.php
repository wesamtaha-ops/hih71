<div class="tu-boxarea">
    <div class="tu-boxsm">
        <div class="tu-boxsmtitle"> 
            <h4>Packages</h4>
        </div>
    </div>
    <div class="tu-box">
        <form class="tu-themeform tu-dhbform">
            <fieldset>
                <div class="tu-themeform__wrap">
                    <div class="form-group-wrap">
                        <div id="packages_section" style="width: 100%">
                            @if(@$teacher_info->packages)
                                @foreach(json_decode($teacher_info->packages) as $package)
                                <div class="packages_container form-group-wrap" style="width: 100%">
                                    @include('components.standard.inputtext', [
                                        'id' => 'package_from', 
                                        'half' => 1, 
                                        'name' => 'package_form', 
                                        'placeholder' => 'From Hour',
                                        'value' => $package->from
                                    ])

                                    @include('components.standard.inputtext', [
                                        'id' => 'package_to', 
                                        'half' => 1, 
                                        'name' => 'package_to', 
                                        'placeholder' => 'To Hour',
                                        'value' => $package->to
                                    ])

                                    @include('components.standard.inputtext', [
                                        'id' => 'package_fee', 
                                        'half' => 1, 
                                        'name' => 'package_fee', 
                                        'placeholder' => 'Fee/Hour',
                                        'value' => $package->fee
                                    ])

                                    @include('components.standard.select', [
                                        'id' => 'package_currency_id', 
                                        'half' => 1, 
                                        'name' => 'package_currency_id', 
                                        'placeholder' => 'Select Currency', 
                                        'options' => $currencies,
                                        'value' => $package->currency_id
                                    ])
                                </div>
                                @endforeach
                            @endif

                            <div class="packages_container form-group-wrap" style="width: 100%">
                                @include('components.standard.inputtext', [
                                    'id' => 'package_from', 
                                    'half' => 1, 
                                    'name' => 'package_form', 
                                    'placeholder' => 'From Hour'
                                ])

                                @include('components.standard.inputtext', [
                                    'id' => 'package_to', 
                                    'half' => 1, 
                                    'name' => 'package_to', 
                                    'placeholder' => 'To Hour'
                                ])

                                @include('components.standard.inputtext', [
                                    'id' => 'package_fee', 
                                    'half' => 1, 
                                    'name' => 'package_fee', 
                                    'placeholder' => 'Fee/Hour'
                                ])

                                @include('components.standard.select', [
                                    'id' => 'package_currency_id', 
                                    'half' => 1, 
                                    'name' => 'package_currency_id', 
                                    'placeholder' => 'Select Currency', 
                                    'options' => $currencies
                                ])
                            </div>
                        </div>

                        <a href="#" id="btn-add-package" class="form-group">
                        <i class="fa fa-plus-circle" style="margin-right: 10px;"></i> Add another package
                        </a>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>


@push('scripts')
<script>
    $(document).ready(function () {
        const packages_container = $('#packages_section').find('.packages_container').last().prop('outerHTML');
        $('#btn-add-package').click(function () {
            $('#packages_section').append(packages_container);
            // $('.selectv').select2()
            return false;
        })
    });
</script>
@endpush