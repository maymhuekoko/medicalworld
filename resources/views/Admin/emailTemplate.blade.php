<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Medical World</title>
</head>
<body>
    
    <div>
        <h2>Medical World</h2>
        <p>{{ $subject }}</p>
        <p>{{ $title }}</p>
        <p>{{ $subtitle }}</p>
        <p>{{ $description }}</p>
        <p>{{ $link }}</p>
        <img src='{{ asset("uploadedfiles/".$photo) }}' alt="medical world">
    </div>
  
</body>
</html>