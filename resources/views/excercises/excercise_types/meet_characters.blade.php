@extends('layouts.app')
@section('main')

<div class="container">
    <h4>Meet the characters excercise</h4>
    <form action="" method="POST">
        <div id="form-container">
            <label for="name" id="name_label" class="form-label">Activity name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter activity name">
        </div>
    </form>

    <button class="btn btn-success" onclick="addItem">Add item</button>
</div>

<script>
    function addItem() {
        const container = document.getElementById('form-container');
        
        var label = document.createElement("label");
        label.innerHTML = "Seleccione imagen";
        label.setAttribute("for", "file_input");

        var input = document.createElement("input");
        input.type = "file";
        input.class = "form-control form-control-sm";
        input.id = "file_input"

        var div = document.createElement("div");
        div.class = "mb-3";

        div.appendChild(label);
        div.appendChild(input);

        container.appendChild(div);
    }
</script>

@endsection