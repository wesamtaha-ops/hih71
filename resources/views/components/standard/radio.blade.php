<div class="form-group @isset($half) form-group-half @endisset @isset($three_half) form-group-3half @endisset">
    <div class="tu-check tu-checksm">
        <input 
            type="radio" 
            id="{{$id}}" 
            name="{{$name}}" 
            @isset($value) value={{$value}} @endisset
            @if(@$selected == @$value) checked @endif
        >
        <label for="{{$id}}">{{$label}}</label>
    </div>
</div>