<div class="form-group @isset($half) form-group-half @endisset @isset($three_half) form-group-3half @endisset">
    <label class="tu-label">{{$placeholder}}</label>
    <div class="tu-placeholderholder">
        <input  id="{{$id}}" 
                name="{{$name}}" 
                class="form-control"
                placeholder="{{$placeholder}}" 
                @isset($type) type="{{$type}}" @endisset
                @isset($disabled) disabled @endisset
                @isset($value) value="{{$value}}" @endisset
                @if(@$required) required @endif
        />
        <div class="tu-placeholder">
            <span>{{$placeholder}}</span>
            @isset($required) <em>*</em> @endisset
        </div>
    </div>
</div>