<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel 5.8 Ajax Example</title>
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}" type="image/x-icon"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
<div class="container">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Manage <b>Tasks</b></h2>
                </div>
                <div class="col-sm-6">
                    <a onclick="addTaskForm();" href="#" class="btn btn-success"
                       data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Task</span></a>
                </div>
                <div class="form-group">
                    <input type="text" class="form-controller" id="search" name="key"></input>
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Task</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{$task->id}}</td>
                    <td>{{$task->task}}</td>
                    <td>{{$task->description}}</td>
                    <td>
                        <a onclick="editTaskForm({{$task->id}});" href="#"><i class="material-icons"
                                                                              data-toggle="tooltip"
                                                                              title="Edit">&#xE254;</i></a>
                        <button class="btn btn-danger btn-delete" type="button" value="{{$task->id}}">Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="clearfix">
            <div class="hint-text">Showing <b>{{$tasks->count()}}</b> out of <b>{{$tasks->total()}}</b> entries</div>
            {{ $tasks->links() }}
        </div>

    </div>
</div>
@include('add')
@include('edit')
{{--@include('delete')--}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    function addTaskForm() {
        $(document).ready(function () {
            $("#add-error-bag").hide()
            $("#addTaskModal").modal('show')

        })
    }

    function editTaskForm(task_id) {
        $.ajax({
            type: 'GET',
            url: '/' + task_id,
            success: function (data) {
                $("#edit-error-bag").hide();
                $("#frmEditTask input[name=task]").val(data.task.task);
                $("#frmEditTask input[name=description]").val(data.task.description);
                $("#frmEditTask input[name=task_id]").val(data.task.id);
                $('#editTaskModal').modal('show');
            },

        });
    }


    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#btn-add").click(function () {

            $.ajax({
                url: '/',
                type: 'POST',
                dataType: 'json',
                data: {
                    task: $("#task").val(),
                    description: $("#description").val(),
                },
                success: function () {
                    window.location.reload();
                }
            })
        })

        $("#btn-edit").click(function () {

            $.ajax({
                type: 'PUT',
                url: '/' + $("#task_id").val(),
                dataType: 'json',
                data: {
                    task: $("#frmEditTask input[name=task]").val(),
                    description: $("#frmEditTask input[name=description]").val(),
                },
                success: function () {
                    window.location.reload()
                }
            })
        })

        $(".btn-delete").click(function () {
            $.ajax({
                url: '/' + $(".btn-delete").val(),
                type: 'DELETE',
                success: function () {
                    window.location.reload()
                }
            })
        })

        $('#search').on('keyup',function(){
            $.ajax({
                type: 'GET',
                url: '/search',
                data: {
                    'key': $("#search").val()
                },
                success:function(data){
                    $('tbody').html(data);
                }
            });
        })
    })
</script>
</body>
</html>
