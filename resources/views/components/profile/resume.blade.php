@php
    $months = range(1,12);
    $months_arr = [];
    foreach($months as $month) {
        $months_arr[] = ['id' => sprintf("%02d", $month), 'name' => sprintf("%02d", $month)];
    }

    $years = range(2023,1950);
    $years_arr = [];
    foreach($years as $year) {
        $years_arr[] = ['id' => $year, 'name' => $year];
    }

    $degrees = [
        [ 'id' => 'Diploma', 'name' => 'Diploma' ],
        [ 'id' => 'Bachelor', 'name' => 'Bachelor' ],
        [ 'id' => 'Master', 'name' => 'Master' ],
        [ 'id' => 'PhD', 'name' => 'PhD' ],
    ];
@endphp

<div class="tu-boxarea">
    <div class="tu-boxsm">
        <div class="tu-boxsmtitle"> 
            <h4>My Resume</h4>
        </div>
    </div>
    <div class="tu-box">
        <div class="tu-themeform tu-dhbform">
            <fieldset>
                <div class="tu-themeform__wrap">
                    <div class="form-group-wrap">
                        <label style="width: 100%">Work experience</label>     
                        <div id="work-experience-conatiner">
                            @if(@$teacher_info->experiences)
                                @foreach($teacher_info->experiences as $experience)
                                    <div class="work-experience-subconatiner grid-3">
                                        @include('components.standard.inputtext', ['id' => 'job_title', 'name' => 'job_title', 'placeholder' => 'Job title', 'type' => 'text', 'value' => $experience->title])
                                        @include('components.standard.select', ['id' => 'from_month', 'name' => 'from_month', 'placeholder' => 'From', 'options' => $months_arr, 'value' => Carbon\Carbon::parse($experience->from_date)->format('m')])
                                        @include('components.standard.select', ['id' => 'from_year', 'name' => 'from_year', 'placeholder' => 'Year', 'options' => $years_arr, 'value' => Carbon\Carbon::parse($experience->from_date)->format('Y')])

                                        @include('components.standard.inputtext', ['id' => 'company_name', 'name' => 'company_name', 'placeholder' => 'Company', 'type' => 'text', 'value' => $experience->company])
                                        @include('components.standard.select', ['id' => 'to_month', 'name' => 'to_month', 'placeholder' => 'To', 'options' => $months_arr, 'value' => Carbon\Carbon::parse($experience->to_date)->format('m')])
                                        @include('components.standard.select', ['id' => 'to_year', 'name' => 'to_year', 'placeholder' => 'Year', 'options' => $years_arr, 'value' => Carbon\Carbon::parse($experience->to_date)->format('Y')])
                                    </div>
                                    <hr />
                                @endforeach
                            @endif

                            <div class="work-experience-subconatiner grid-3">
                                @include('components.standard.inputtext', ['id' => 'job_title', 'name' => 'job_title', 'placeholder' => 'Job title', 'type' => 'text'])
                                @include('components.standard.select', ['id' => 'from_month', 'name' => 'from_month', 'placeholder' => 'From', 'options' => $months_arr])
                                @include('components.standard.select', ['id' => 'from_year', 'name' => 'from_year', 'placeholder' => 'Year', 'options' => $years_arr])

                                @include('components.standard.inputtext', ['id' => 'company_name', 'name' => 'company_name', 'placeholder' => 'Company', 'type' => 'text'])
                                @include('components.standard.select', ['id' => 'to_month', 'name' => 'to_month', 'placeholder' => 'To', 'options' => $months_arr])
                                @include('components.standard.select', ['id' => 'to_year', 'name' => 'to_year', 'placeholder' => 'Year', 'options' => $years_arr])
                            </div>
                            <hr />
                        </div>

                        <a href="#"  style="margin-bottom: 30px;" id="btn-add-work-experience">
                            <i class="fa fa-plus-circle"></i> Add another Work Experience
                        </a>

                        <label style="width: 100%">Professional certificates</label>
                
                        <div id="professional-certificates-conatiner">
                            @if(isset($teacher_info->trains) && !empty($teacher_info->trains))
                                @foreach($teacher_info->trains as $train)
                                    <div class="professional-certificates-subconatiner grid-3">
                                        @include('components.standard.inputtext', ['id' => 'institution', 'name' => 'institution', 'placeholder' => 'Institution', 'type' => 'text', 'value' => $train->instituation])
                                        @include('components.standard.select', ['id' => 'from_month', 'name' => 'from_month', 'placeholder' => 'From', 'options' => $months_arr, 'value' => Carbon\Carbon::parse($train->from_date)->format('m')])
                                        @include('components.standard.select', ['id' => 'from_year', 'name' => 'from_year', 'placeholder' => 'Year', 'options' => $years_arr, 'value' => Carbon\Carbon::parse($train->from_date)->format('Y')])

                                        @include('components.standard.inputtext', ['id' => 'subject', 'name' => 'subject', 'placeholder' => 'Subject', 'type' => 'text', 'value' => $train->subject])
                                        @include('components.standard.select', ['id' => 'to_month', 'name' => 'to_month', 'placeholder' => 'To', 'options' => $months_arr, 'value' => Carbon\Carbon::parse($train->to_date)->format('m')])
                                        @include('components.standard.select', ['id' => 'to_year', 'name' => 'to_year', 'placeholder' => 'Year', 'options' => $years_arr, 'value' => Carbon\Carbon::parse($train->to_date)->format('Y')])
                                    </div>
                                    <hr />
                                @endforeach
                            @endif

                            <div class="professional-certificates-subconatiner grid-3">
                                @include('components.standard.inputtext', ['id' => 'institution', 'name' => 'institution', 'placeholder' => 'Institution', 'type' => 'text'])
                                @include('components.standard.select', ['id' => 'from_month', 'name' => 'from_month', 'placeholder' => 'From', 'options' => $months_arr])
                                @include('components.standard.select', ['id' => 'from_year', 'name' => 'from_year', 'placeholder' => 'Year', 'options' => $years_arr])

                                @include('components.standard.inputtext', ['id' => 'subject', 'name' => 'subject', 'placeholder' => 'Subject', 'type' => 'text'])
                                @include('components.standard.select', ['id' => 'to_month', 'name' => 'to_month', 'placeholder' => 'To', 'options' => $months_arr])
                                @include('components.standard.select', ['id' => 'to_year', 'name' => 'to_year', 'placeholder' => 'Year', 'options' => $years_arr])
                            </div>
                            <hr />
                        </div>

                        <a href="#"  style="margin-bottom: 30px;" id="btn-add-professional-certificates">
                            <i class="fa fa-plus-circle"></i> Add another Professional Certificate
                        </a>

                        <label style="width: 100%">Higher education degrees</label>
                
                        <div id="higher-education-degrees-conatiner" style="width: 100%">
                            @if(@$teacher_info->certificates)
                                @foreach($teacher_info->certificates as $certificate)
                                    <div class="grid-2 higher-education-degrees-subconatiner">
                                        @include('components.standard.inputtext', ['id' => 'university', 'name' => 'university', 'placeholder' => 'University', 'type' => 'text', 'value' => $certificate->university])
                                        @include('components.standard.select', ['id' => 'degree', 'name' => 'degree', 'placeholder' => 'Degree', 'options' => $degrees, 'value' => $certificate->degree])
                                        @include('components.standard.select', ['id' => 'from_year', 'name' => 'from_year', 'placeholder' => 'From', 'options' => $years_arr, 'value' => Carbon\Carbon::parse($certificate->from_date)->format('Y')])
                                        @include('components.standard.select', ['id' => 'to_year', 'name' => 'to_year', 'placeholder' => 'To', 'options' => $years_arr, 'value' => Carbon\Carbon::parse($certificate->to_date)->format('Y')])
                                        @include('components.standard.upload', ['id' => 'university_image', 'name' => 'university_image', 'value' => $certificate->image])
                                    </div>
                                    <hr />
                                @endforeach
                            @endif
                            <div class="grid-2 higher-education-degrees-subconatiner">
                                @include('components.standard.inputtext', ['id' => 'university', 'name' => 'university', 'placeholder' => 'University', 'type' => 'text'])
                                @include('components.standard.select', ['id' => 'degree', 'name' => 'degree', 'placeholder' => 'Degree', 'options' => $degrees])
                                @include('components.standard.select', ['id' => 'from_year', 'name' => 'from_year', 'placeholder' => 'From', 'options' => $years_arr])
                                @include('components.standard.select', ['id' => 'to_year', 'name' => 'to_year', 'placeholder' => 'To', 'options' => $years_arr])
                                @include('components.standard.upload', ['id' => 'university_image', 'name' => 'university_image'])
                            </div>
                        </div>

                        <a href="#"  style="margin-bottom: 30px;" id="btn-add-higher-education-degrees">
                            <i class="fa fa-plus-circle"></i> Add another Higher education degrees
                        </a>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>


@push('scripts')
<script>
    $(document).ready(function () {
        const work_experience_conatiner = $('#work-experience-conatiner').find('.work-experience-subconatiner').last().prop('outerHTML') + "<hr />";
        $('#btn-add-work-experience').click(function () {
            $('#work-experience-conatiner').append(work_experience_conatiner);
            $('.selectv').select2()
            return false;
        })

        const professional_certificates_conatiner = $('#professional-certificates-conatiner').find('.professional-certificates-subconatiner').last().prop('outerHTML') + "<hr />";
        $('#btn-add-professional-certificates').click(function () {
            $('#professional-certificates-conatiner').append(professional_certificates_conatiner);
            $('.selectv').select2()
            return false;
        })

        const higher_education_degrees_conatiner = $('#higher-education-degrees-conatiner').find('.higher-education-degrees-subconatiner').last().prop('outerHTML') + "<hr />";
        $('#btn-add-higher-education-degrees').click(function () {
            $('#higher-education-degrees-conatiner').append(higher_education_degrees_conatiner);
            $('.selectv').select2()
            return false;
        })
    });
</script>
@endpush