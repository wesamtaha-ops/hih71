<div class="form-group @isset($half) form-group-half @endisset @isset($three_half) form-group-3half @endisset">
    <label class="tu-label">{{$placeholder}}</label>
    <div class="tu-placeholderholder">
        <textarea id="{{$id}}" 
                name="{{$name}}" 
                class="form-control" 
                required="" 
                placeholder="{{$placeholder}}" 
                @if(@$required) required @endif
                @isset($disabled) disabled @endisset>{{@$value}}</textarea>
        <div class="tu-placeholder">
            <span>{{$placeholder}}</span>
        </div>
    </div>
</div>