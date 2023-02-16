<div class="tu-boxarea">
    <div class="tu-boxsm">
        <div class="tu-boxsmtitle">
            <h4>I can teach</h4>
        </div>
    </div>
    <div class="tu-box">
        <div class="accordion tu-accordionedu" id="accordionFlushExampleaa">
            <div id="tu-edusortable" class="tu-edusortable">
                @foreach($topics as $index => $topic)
                <div class="tu-accordion-item">
                    <div class="tu-expwrapper">
                        <div class="tu-accordionedu">
                            <div class="tu-expinfo">
                                <div class="tu-accodion-holder">
                                    <h5 class="collapsed"  data-bs-toggle="collapse" data-bs-target="#flush-{{$index}}" aria-expanded="false" aria-controls="flush-{{$index}}">{{ $index }}</h5>
                                </div>
                                <i class="icon icon-plus" role="button" data-bs-toggle="collapse" data-bs-target="#flush-{{$index}}" aria-expanded="false" aria-controls="flush-{{$index}}"></i>
                            </div>
                        </div>
                    </div>
                    <div id="flush-{{$index}}" class="accordion-collapse collapse"  data-bs-parent="#accordionFlushExampleaa">
                        <div class="tu-edubodymain">
                            <div class="tu-accordioneduc">
                                <div class="form-group-wrap" style="margin: auto">
                                @foreach($topic as $single_topic)
                                    @include('components.standard.checkbox', [
                                        'id' => 'topic_' . $single_topic->id, 
                                        'name' => 'topic', 
                                        'three_half' => 1,
                                        'label' => $single_topic->name_en, 
                                        'value' => $single_topic->id, 'selected' => @$teacher_info->topics ? $teacher_info->topics->pluck('topic_id') : ''
                                    ])
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <label style="width: 100%; margin-top: 50px;">How would you like to teach or train?</label>

        
        <div id="teach_online_container">


            @include('components.standard.inputtext', [
                'id' => 'teach_online_container_hour', 
                'name' => 'teach_online_container_hour', 
                'placeholder' => 'My rate per hour', 
                'value' => @$fees             
            ])

            @include('components.standard.select', [
                'id' => 'teach_online_container_currency', 
                'name' => 'teach_online_container_currency', 
                'placeholder' => 'Select Currencies', 
                'options' => $currencies, 
                'header' => 'false',
                'value' => @$currency_id
            ])

        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        if($('#teach_online').is(':checked')) {
            $('#teach_online_container').slideToggle();
        }

        $('#teach_online').click(function () {
            $('#teach_online_container').slideToggle();
        })
    })
</script>
@endpush