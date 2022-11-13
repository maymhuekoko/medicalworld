<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Medical World</title>
</head>
<body>

    <div style="width: 100%;">
        <div style="width:100%;">
            <div style="width:100%; text-align: center;">
                <h4 style="font-weight: bold;color: white; background-color:#32549b; width: 100%;padding: 10px; text-align: center;">{{ $subject }}</h4>
                <h1>{{ $title }}</h1>
                <h2>{{ $subtitle }}</h2>
                <p style="text-align: center;font-size: 18px;">{{ $description }}</p>
                <img src='{{ asset("uploadedfiles/".$photo) }}' alt="{{$photo}}">
                <br><a href="{{ $link }}" style="text-decoration: none; background-color: #32549b;color: white;padding: 10px;margin-top: 10px;border-radius: 5px; display: inline-block;">Go To Link</a>
                <br><span style="margin-top: 20px; display: inline-block;text-decoration: none;">www.medicalworld.com.mm</span>
            </div>
        </div>
    </div>
</body>
</html>
