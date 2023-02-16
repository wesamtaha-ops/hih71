@if(@$header != 'false')
<div class="form-group @isset($half) form-group-half @endisset @isset($three_half) form-group-3half @endisset">
@endif
    <label class="tu-label">{{$placeholder}}</label>
    <div class="tu-select">
        <select 
            id="{{$id}}" 
            name="{{$name}}" 
            data-placeholder="{{$placeholder}}" 
            data-placeholderinput="{{$placeholder}}" 
            class="form-control selectv"
            @if(@$multiple) multiple @endif
            @isset($required) required @endisset
        >
            <option label="{{$placeholder}}"></option>
            @foreach($options as $option)
                @if(is_array(@$value))
                    <option value="{{$option['id']}}" @if(in_array($option['id'], $value)) selected @endif>{{$option['name']}}</option>
                @else
                    <option value="{{$option['id']}}" @if(@$value == $option['id']) selected @endif>{{$option['name']}}</option>
                @endif
            @endforeach
        </select>
    </div>
@if(@$header != 'false')
</div>
@endif