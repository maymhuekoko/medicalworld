<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{route('execelImport')}}" enctype="multipart/form-data" method="POST">
        @csrf
        <input type="file" name="select_file">
        <button type="submit" class="btn btn-danger">Submit</button>
    </form>
</body>
</html>