@php $rand = mt_rand(1000000, 9999999); @endphp

<form action="{{route('image.store')}}" enctype="multipart/form-data" method="post" class="form-{{$rand}} form-group @isset($half) form-group-half @endisset @isset($three_half) form-group-3half @endisset">
    @csrf
    <input type="file" name="file-{{$rand}}" />
    <input type="hidden" id="{{$name}}" name="upload-{{$rand}}" value={{@$value}} />

</form>


@push('scripts')
<script>
$(document).ready(function (e) {
    $('body').on('submit', '.form-{{$rand}}',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var that = this
        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                $(that).find("[name=upload-{{$rand}}]").val(data)
            },
            error: function(data){
                console.log("error");
                console.log(data);
            }
        });
    }));

    $('body').on("change", "[name=file-{{$rand}}]",  function() {
        $(this).parent(".form-{{$rand}}").submit();
    });
});
</script>
@endpush