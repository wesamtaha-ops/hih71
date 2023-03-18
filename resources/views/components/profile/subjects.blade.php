<div class="tu-boxarea">
    <div class="tu-boxsm">
        <div class="tu-boxsmtitle">
            <h4>@lang('app.i_can_teach')</h4>
        </div>
    </div>
    <div class="tu-box">
        <div class="accordion tu-accordionedu" id="accordionFlushExampleaa">
            <div id="tu-edusortable" class="tu-edusortable">
                @foreach($topics as $index => $topic)
                @php $var = preg_replace('/\s+/', '', $index) @endphp
                <div class="tu-accordion-item">
                    <div class="tu-expwrapper">
                        <div class="tu-accordionedu">
                            <div class="tu-expinfo">
                                <div class="tu-accodion-holder">
                                    <h5 class="collapsed"  data-bs-toggle="collapse" data-bs-target="#flush-{{$var}}" aria-expanded="false" aria-controls="flush-{{$var}}">{{ $index }}</h5>
                                </div>
                                <i class="icon icon-plus" role="button" data-bs-toggle="collapse" data-bs-target="#flush-{{$var}}" aria-expanded="false" aria-controls="flush-{{$var}}"></i>
                            </div>
                        </div>
                    </div>
                    <div id="flush-{{$var}}" class="accordion-collapse collapse"  data-bs-parent="#accordionFlushExampleaa">
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
    </div>
</div>