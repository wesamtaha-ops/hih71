@extends('layouts.admin')

@section('title')
    List Topics
@endsection

@section('content')
    <div id="jsGrid"></div>
@endsection

@section('scripts')
<script type="text/javascript">

    let topics = {!! json_encode($topics->toArray()) !!};
    let parents = {!! json_encode($parents->toArray()) !!};
    parents = [{'id': -1, 'name_en': '' }, ...parents]

 
    $("#jsGrid").jsGrid({
        width: "100%",
        height: "85vh",
 
        inserting: true,
        editing: true,
        sorting: true,
        paging: true,
        data: topics,
 
        fields: [
            { name: "name_ar", title: "Name Ar", type: "text", width: 150, validate: "required" },
            { name: "name_en", title: "Name En", type: "text", width: 150, validate: "required" },
            { name:"full_image",  title: "Image", type: "file", width: 50, 
                itemTemplate: function(val, item) {
                    return $("<img>").attr("src", val).css({ height: 50, width: 50 });
                },
                insertTemplate: function() {
                    var insertControl = this.insertControl = $("<input>").prop("type", "file");
                    return insertControl;
                },
                editTemplate: function() {
                    var editControl = this.editControl = $("<input>").prop("type", "file");
                    return editControl;
                },
                insertValue: function() {
                    return this.insertControl[0].files[0]; 
                },
                editValue: function() {
                    return this.editControl[0].files[0]; 
                },
            },
            { name: "parent_id", title: "Parent", type: "select", items: parents, valueField: "id", textField: "name_en" },
            { type: "control" }
        ],

        onItemInserting: function(args) {
            var formData = new FormData();
            formData.append("name_ar", args.item.name_ar);
            formData.append("name_en", args.item.name_en);
            formData.append("parent_id", args.item.parent_id);
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
            formData.append("parent_id", args.item.parent_id);
            
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