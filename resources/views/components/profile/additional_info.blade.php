<div class="tu-boxarea">
    <div class="tu-boxsm">
        <div class="tu-boxsmtitle">
            <h4>Additional Information</h4>
        </div>
    </div>
    <div class="tu-box">
        <form class="tu-themeform tu-dhbform">
            <fieldset>
                <div class="tu-themeform__wrap">
                    <div class="form-group-wrap">
                        <label style="width: 100%">Which of the following students' level do you prefer to train or teach?</label>
                        @foreach($levels as $i => $level)
                            @include('components.standard.checkbox', [
                                'name' => 'level', 
                                'three_half' => 1,
                                'id' => 'level' . $level['id'], 
                                'label' => $level['name'], 
                                'value' => $level['id'],
                                'selected' => @$teacher_info->levels ? $teacher_info->levels->pluck('level_id') : ''
                            ])
                        @endforeach

                        <label style="width: 100%">Which Curriculum you teach? you can select more than one.</label>
                        @foreach($curriculums as $i => $curriculum)
                            @include('components.standard.checkbox', [
                                'name' => 'curriculum', 
                                'id' => 'curriculum' . $curriculum['id'], 
                                'three_half' => 1,
                                'label' => $curriculum['name'], 
                                'value' => $curriculum['id'], 
                                'selected' => @$teacher_info->curriculums ? $teacher_info->curriculums->pluck('curriculum_id') : ''
                            ])
                        @endforeach

                        
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>