@extends('layouts.admin')

@section('title')
    List Topics
@endsection

@section('content')
    <div id="jsGrid"></div>
@endsection

@section('scripts')
<script type="text/javascript">
 
    $("#jsGrid").jsGrid({
        width: "100%",
        height: "85vh",
 
        inserting: false,
        editing: false,
        sorting: true,
        paging: true,
        autoload: true,
        pageLoading: true,

        pageSize: 10,

        // data: topics,

        controller: {
            loadData: function(filter) {
                const {pageIndex, pageSize} = filter

                return $.ajax({
                    url: `/admin/user/list?skip=${pageIndex}&take=${pageSize}`,
                    dataType: "json"
                });
            }
        },

 
        fields: [
            { name: "name", title: "name", type: "text", width: 150, validate: "required" },
            { name: "email", title: "email", type: "text", width: 150, validate: "required" },
            { type: "control" }
        ],
        
        onItemInserting: function(args) {
            var formData = new FormData();
            formData.append("name_ar", args.item.name_ar);
            formData.append("name_en", args.item.name_en);
            formData.append("image", args.item.full_image, args.item.full_image.name);

            return $.ajax({
                method: "post",
                type: "POST",
                url: `/admin/topic`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                contentType: false,
                processData: false
            });
        },

        onItemUpdating: function(args) {
            
            var formData = new FormData();
            formData.append("_method", "PUT");
            formData.append("name_ar", args.item.name_ar);
            formData.append("name_en", args.item.name_en);
            
            if (!(typeof args.item.full_image === 'string' || args.item.full_image instanceof String))
                formData.append("image", args.item.full_image, args.item.full_image.name);

            return $.ajax({
                type: "post",
                url: `/admin/topic/${args.item.id}`,
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
                url: `/admin/topic/${args.item.id}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        },
    });
</script>
@endsection