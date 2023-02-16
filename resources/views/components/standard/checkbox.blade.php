<div class="form-group @isset($half) form-group-half @endisset @isset($three_half) form-group-3half @endisset">
    <div class="tu-check tu-checksm">
        <input 
            type="checkbox" 
            id="{{$id}}" 
            name="{{$name}}" 
            @isset($value) value={{$value}} @endisset
            @if(isset($selected) && is_array(json_decode($selected)) && in_array($value, json_decode($selected))) checked @endif
        >
        <label for="{{$id}}">{{$label}}</label>
    </div>
</div>