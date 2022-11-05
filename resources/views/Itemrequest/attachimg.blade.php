<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/img/bahosi.png')}}">
    
                            <!--     Template Link -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap-datetimepicker.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
    <title>Documents </title>

    {{-- <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css"> --}}

    <script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script> 
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></script>  --}}
    <style>
        .preloader{
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('../image/Profile/loader.gif') 50%50% no-repeat rgb(249, 249, 249);
            opacity: 0.9;
        }
        .imgbackground{
            width: 100%;
            height: 100vh;
            opacity: 0.9;
            background-color: black;
        }
        .plaintext {
            outline:0;
            border-width:0 0 1px;
        }
        .previous {
            position: fixed;
            top: 50%;
            left: 10%;
        }
        .next {
            position: fixed;
            top: 50%;
            right: 10%;
        }
        .back {
            position: fixed;
            top: 5%;
            left: 5%;
        }
    </style>
    <title>@yield('title') </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body style="background-color: black">
   
    @include('sweet::alert')

    <div class="imgbackground text-center">
        <div class="preloader" id="preloaders"></div>
        
        {{-- <img src="{{$allimgs[0]->attachment}}" class="img-fluid attachmentimg" alt=""> --}}
        {{-- <iframe src ="{{$allimgs[0]->attachment}}" class="img-fluid text-center attachmentimg" style="width: -webkit-fill-available;height: 100vh;"></iframe> --}}
        
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-body">
                    
                    
                        @php
                            $photo = explode('.',$attach_file_path);
                            $extension= $photo[1];
                        @endphp
                     <div id="attachmentwrapper">
                        @if ($extension=='pdf')
                        <iframe src ="{{$attach_file_path}}" class="img-fluid text-center" id="attachmentpdf" style="width: -webkit-fill-available;height: 100vh;" ></iframe>
                        @else
                        <img src ="{{$attach_file_path}}" class="img-fluid text-center" id="attachmentimg" style="width: -webkit-fill-available;height: 100vh;" >
                        @endif
                     </div>
                </div>
              </div>
            </div>
            
            

      <div class="mt-2 text-white">
          <span class="back" style="font-size: 25px;"> <a class="pinkcolor" href="/Order/PO-Details/{{$po_id}}" >Back To PO</a></span>
        <a class="previous"><i class="fas fa-chevron-circle-left  text-primary" style="font-size: 40px;cursor: pointer;"></i></a>
        <a class="px-2 next"><i class="fas fa-chevron-circle-right text-primary" style="font-size: 40px;cursor: pointer;"></i></a>
      </div>

    </div>


    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script> --}}

    <script src="{{asset('assets/js/moment.min.js')}}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script> 
    <script src="{{asset('assets/js/jquery.dataTables1.min.js')}}"></script> 

    <script src="{{asset('assets/js/select2.min.js')}}"></script>

    <script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>

    <script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>

    <script src="{{asset('assets/js/jquery.slimscroll.js')}}"></script>

    <script src="{{asset('assets/js/app.js')}}"></script>

    <script src="{{asset('assets/js/validation.js')}}"></script>

    @yield('js')
    
</body>


</html>

<script type="text/javascript">

  //loader
    $(window).on('load', function(){
        $("#preloaders").fadeOut(100);
    });
   

    
</script>