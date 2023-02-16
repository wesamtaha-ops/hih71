@extends('layouts.admin')

@section('title')
    List Countries
@endsection

@section('content')
    <div id="jsGrid"></div>
@endsection

@section('scripts')
<script type="text/javascript">

    let countries = {!! json_encode($countries->toArray()) !!};
 
    $("#jsGrid").jsGrid({
        width: "100%",
        height: "85vh",
 
        inserting: true,
        editing: true,
        sorting: true,
        paging: true,
        data: countries,
 
        fields: [
            { name: "name_ar", title: "Name Ar", type: "text", width: 150, validate: "required" },
            { name: "name_en", title: "Name En", type: "text", width: 150, validate: "required" },
            { type: "control" }
        ],

        onItemInserting: function(args) {
            return $.ajax({
                method: "post",
                type: "POST",
                url: `/admin/country`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: args.item
            });
        },

        onItemUpdating: function(args) {
            var formData = new FormData();
            formData.append("_method", "PUT");
            formData.append("name_ar", args.item.name_ar);
            formData.append("name_en", args.item.name_en);

            return $.ajax({
                type: "post",
                url: `/admin/country/${args.item.id}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: formData,
                contentType: false,
                processData: false
            });
        },

        onItemDeleting: function(args) {
            return $.ajax({
                method: "delete",
                type: "delte",
                url: `/admin/country/${args.item.id}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        },
    });
</script>
@endsection