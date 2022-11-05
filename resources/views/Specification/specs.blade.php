@extends('master')

@section('title','Category List')

@section('place')

@endsection

@section('content')

{{--    Design--}}
    @if($type == 1)
        @php
        $name = "Design";
        @endphp
        <div class="row page-titles">
            <div class="col-md-5 col-8 align-self-center">
                <h4 class="font-weight-normal">{{$name}} List</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="card shadow-sm rounded">
                    <div class="card-header">
                        <div class="d-flex">
                            <form action="{{route('designImport')}}" enctype="multipart/form-data" method="post">
                                @csrf
                                <input type="file" id="importInput" name="import_file" required>
                                <button type="submit" id="importBtn" class="btn btn-danger">Import</button>
                            </form>
                            <a href="{{ route('designExport') }}" class="btn btn-primary mx-2">Export</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="table-responsive text-black">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{$name}} Name</th>
                                    <th>Description</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody id="category_table">
                                @forelse(\App\Design::all() as $design)
                                    <tr>
                                        <td>{{ $design->id }}</td>
                                        <td>{{ $design->design_name }}</td>
                                        <td class="w-50">{{ $design->design_description }}</td>
                                        <td class="text-center">
                                            <div class="btn-group-sm">
                                                <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_design{{$design->id}}"><i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{route('design.destroy',$design->id)}}" class="btn btn-outline-primary">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        </td>
{{--                                        Modal--}}
                                        <div class="modal fade" id="edit_design{{$design->id}}" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Design</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body p-3">
                                                        <form method="post" action="{{route('design.update',$design->id)}}">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label class="font-weight-normal">New Design Name</label>
                                                                <input type="text" name="design_name" class="form-control" value="{{$design->design_name}}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="font-weight-normal">New Design Description</label>
                                                                <input type="text" name="design_description" class="form-control" value="{{$design->design_description}}">
                                                            </div>
                                                            <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary" value="Update">
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">There is no design yet.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title">Create New {{$name}}</h3>
                        <form class="form-material m-t-40" method="post" action="{{ route('design.store')}}">
                            @csrf
                            <input type="hidden" name="type" value="{{ $type }}">
                            <div class="form-group">
                                <input type="text" name="design_name" class="form-control @error('design_name') is-invalid @enderror" placeholder="Enter {{$name}} Name" >
                                @error('design_name')
                                <span class="invalid-feedback alert alert-danger" role="alert" height="100">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" name="design_description" class="form-control" placeholder="Enter Description (Optional)">

                            </div>
                            <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary rounded" value="Add">
                        </form>
                    </div>
                </div>
            </div>
{{--            Fabric--}}
    @elseif($type == 2)
                @php
                    $name = "Fabric";
                @endphp
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h4 class="font-weight-normal">{{$name}} List</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="card shadow-sm rounded">
                            <div class="card-header">
                                <div class="d-flex">
                                    <form action="{{route('fabricImport')}}" enctype="multipart/form-data" method="post">
                                        @csrf
                                        <input type="file" name="import_file" required>
                                        <button type="submit" class="btn btn-danger">Import</button>
                                    </form>
                                    <a href="{{ route('fabricExport') }}" class="btn btn-primary mx-2">Export</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="table-responsive text-black">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th class="text-black">#</th>
                                            <th class="text-black">{{$name}} Name</th>
                                            <th class="text-black">Description</th>
                                            <th  class="text-black text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="category_table">
                                        @forelse(\App\Fabric::all() as $fabric)
                                            <tr>
                                                <td>{{ $fabric->id }}</td>
                                                <td>{{ $fabric->fabric_name }}</td>
                                                <td class="w-50">{{ $fabric->fabric_description }}</td>
                                                <td class="text-center">
                                                    <div class="btn-group-sm">
                                                        <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_fabric{{$fabric->id}}"><i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="{{route('fabric.destroy',$fabric->id)}}" class="btn btn-outline-primary" title="Delete Button">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </div>
                                                </td>
{{--                                                Modal--}}
                                                <div class="modal fade" id="edit_fabric{{$fabric->id}}" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit Fabric</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body p-3">
                                                                <form method="post" action="{{route('fabric.update',$fabric->id)}}">
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <label class="font-weight-normal">New Fabric Name</label>
                                                                        <input type="text" name="fabric_name" class="form-control" value="{{$fabric->fabric_name}}">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="font-weight-normal">New Fabric Description</label>
                                                                        <input type="text" name="fabric_description" class="form-control" value="{{$fabric->fabric_description}}">
                                                                    </div>
                                                                    <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary" value="Update">
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">There is no fabric yet.</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <h3 class="card-title">Create New {{$name}}</h3>
                                <form class="form-material m-t-40" method="post" action="{{ route('fabric.store')}}">
                                    @csrf
                                    <input type="hidden" name="type" value="{{ $type }}">
                                    <div class="form-group">
                                        <input type="text" name="fabric_name" class="form-control @error('fabric_name') is-invalid @enderror" placeholder="Enter {{$name}} Name" >
                                        @error('fabric_name')
                                        <span class="invalid-feedback alert alert-danger" role="alert" height="100">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="fabric_description" class="form-control " placeholder="Enter Description (Optional)">
                                    </div>
                                    <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary rounded" value="Add">
                                </form>
                            </div>
                        </div>
                    </div>

{{--                    Colour--}}
                @elseif($type == 3)
                @php
                    $name = "Colour";
                @endphp
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h4 class="font-weight-normal">{{$name}} List</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5">
                        <div class="card shadow-sm rounded">
                            <div class="card-header">
                                <div class="d-flex">
                                    <form action="{{route('colourImport')}}" enctype="multipart/form-data" method="post">
                                        @csrf
                                        <input type="file" name="import_file" required>
                                        <button type="submit" class="btn btn-danger">Import</button>
                                    </form>
                                    <a href="{{ route('colourExport') }}" class="btn btn-primary mx-2">Export</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="table-responsive text-black">
                                    <table class="table align-middle">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{$name}} Name</th>
                                            <th>Description</th>
                                            <th>Releated Fabric</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="category_table">
                                        @forelse(\App\Colour::all() as $colour)
                                            <tr>
                                                <td>{{ $colour->id }}</td>
                                                <td>{{ $colour->colour_name }}</td>
                                                <td>{{ $colour->colour_description }}</td>
                                                <td>{{ $colour->fabric->fabric_name?? 'Default Fabric' }}</td>
                                                <td class="text-center">
                                                    <div class="btn-group-sm">
                                                        <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_colour{{$colour->id}}"><i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="{{route('colour.destroy',$colour->id)}}" class="btn btn-outline-primary" title="Delete Button">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </div>
                                                </td>
{{--                                                Modal--}}
                                                <div class="modal fade" id="edit_colour{{$colour->id}}" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit Colour</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body p-3">
                                                                <form method="post" action="{{route('colour.update',$colour->id)}}">
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <label class="font-weight-normal">New Colour Name</label>
                                                                        <input type="text" name="colour_name" class="form-control" value="{{$colour->colour_name}}">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="font-weight-normal">New Colour Description</label>
                                                                        <input type="text" name="colour_description" class="form-control" value="{{$colour->colour_description}}">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="font-weight-normal">New Fabric</label>
                                                                        <select name="fabric_id" class="form-control select2">
                                                                            @foreach(\App\Fabric::all() as $fabric)
                                                                            <option value="{{$fabric->id}}">{{$fabric->fabric_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary" value="Update">
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">There is no colour yet.</td>
                                            </tr>
                                        @endforelse


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <h3 class="card-title">Create New {{$name}}</h3>
                                <form class="form-material m-t-40" method="post" action="{{ route('colour.store')}}">
                                    @csrf
                                    <input type="hidden" name="type" value="{{ $type }}">
                                    <div class="form-group">
                                        <input type="text" name="colour_name" class="form-control @error('colour_name') is-invalid @enderror" placeholder="Enter {{$name}} Name" >
                                        @error('colour_name')
                                        <span class="invalid-feedback alert alert-danger" role="alert"  height="100">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="colour_description" class="form-control" placeholder="Enter {{$name}} Description (Optional)">
                                    </div>

                                    <div class="form-group">
                                        <select name="fabric_id" class="form-control select2">
                                            <option value="">Choose Fabric</option>
                                        @foreach(\App\Fabric::all() as $fabric)
                                                <option value="{{$fabric->id}}">{{$fabric->fabric_name}}</option>
                                            @endforeach
                                        </select>

                                        @error('')
                                        <span class="invalid-feedback alert alert-danger" role="alert"  height="100"></span>
                                        @enderror
                                    </div>
                                    <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary rounded" value="Add">
                                </form>
                            </div>
                        </div>
                    </div>

{{--                    Size--}}
                @elseif($type == 4)
                @php
                    $name = "Size";
                @endphp
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h4 class="font-weight-normal">{{$name}} List</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5">
                        <div class="card shadow-sm rounded">
                            <div class="card-header">
                                <div class="d-flex">
                                    <form action="{{route('sizeImport')}}" enctype="multipart/form-data" method="post">
                                        @csrf
                                        <input type="file" name="import_file" required>
                                        <button type="submit" class="btn btn-danger">Import</button>
                                    </form>
                                    <a href="{{ route('sizeExport') }}" class="btn btn-primary mx-2">Export</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-8">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="table-responsive text-black">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{$name}} Name</th>
                                            <th>Description</th>
                                            <th>Related Gender</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="category_table">
                                        @forelse(\App\Size::all() as $size)
                                            <tr>
                                                <td>{{$size->id}}</td>
                                                <td>{{$size->size_name }}</td>
                                                <td>{{$size->size_description}}</td>
                                                <td>{{$size->gender->gender_name ?? 'Default Gender'}}</td>
                                                <td>
                                                    <div class="btn-group-sm">
                                                        <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_size{{$size->id}}"><i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="{{route('size.destroy',$size->id)}}" class="btn btn-outline-primary" title="Delete Button">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                                {{--                                                Modal--}}
                                                <div class="modal fade" id="edit_size{{$size->id}}" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit Size</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body p-3">
                                                                <form method="post" action="{{route('size.update',$size->id)}}">
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <label class="font-weight-normal">New Size Name</label>
                                                                        <input type="text" name="size_name" class="form-control  @error('message') is-invalid @enderror" value="{{$size->size_name}}">
                                                                        @error('design_name')
                                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="font-weight-normal">New Size Description</label>
                                                                        <input type="text" name="size_description" class="form-control" value="{{$size->size_description}}">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="font-weight-normal">New Gender</label>
                                                                        <select name="gender_id" class="form-control select2">
                                                                            @foreach(\App\Gender::all() as $gender)
                                                                                <option value="{{$gender->id}}">{{$gender->gender_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary" value="Update">
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">There is no size yet.</td>
                                            </tr>
                                        @endforelse


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <h3 class="card-title">Create New {{$name}}</h3>
                                <form class="form-material m-t-40" method="post" action="{{ route('size.store')}}">
                                    @csrf
                                    <input type="hidden" name="type" value="{{ $type }}">
                                    <div class="form-group">
                                        <input type="text" name="size_name" class="form-control @error('size_name') is-invalid @enderror" placeholder="Enter {{$name}} Name" >

                                        @error('size_name')
                                        <span class="invalid-feedback alert alert-danger" role="alert"  height="100">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="size_description" class="form-control" placeholder="Enter {{$name}} Description (Optional)">
                                    </div>
                                    <div class="form-group">
                                        <select name="gender_id" class="form-control select2">
                                            <option value="">Choose Gender</option>
                                            @foreach(\App\Gender::all() as $gender)
                                                <option value="{{$gender->id}}">{{$gender->gender_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary rounded" value="Add">
                                </form>
                            </div>
                        </div>
                    </div>


                {{--                    Gender--}}
                @elseif($type == 5)
                @php
                    $name = "Gender";
                @endphp
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h4 class="font-weight-normal">{{$name}} List</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5">
                        <div class="card shadow-sm rounded">
                            <div class="card-header">
                                <div class="d-flex">
                                    <form action="{{route('genderImport')}}" enctype="multipart/form-data" method="post">
                                        @csrf
                                        <input type="file" name="import_file" required>
                                        <button type="submit" class="btn btn-danger">Import</button>
                                    </form>
                                    <a href="{{ route('genderExport') }}" class="btn btn-primary mx-2">Export</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-8">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="table-responsive text-black">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{$name}} Name</th>
                                            <th>Description</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="category_table">
                                        @forelse(\App\Gender::all() as $gender)
                                            <tr>
                                                <td>{{$gender->id}}</td>
                                                <td>{{$gender->gender_name}}</td>
                                                <td>{{$gender->gender_description}}</td>
                                                <td class="text-center">
                                                    <div class="btn-group-sm">
                                                        <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_gender{{$gender->id}}"><i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="{{route('gender.destroy',$gender->id)}}" class="btn btn-outline-primary" title="Delete Button">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>

                                                    </div>
                                                </td>
                                                {{--                                                Modal--}}
                                                <div class="modal fade" id="edit_gender{{$gender->id}}" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit Gender</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body p-3">
                                                                <form method="post" action="{{route('gender.update',$gender->id)}}">
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <label class="font-weight-normal">New Gender Name</label>
                                                                        <input type="text" name="gender_name" class="form-control" value="{{$gender->gender_name}}">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="font-weight-normal">New Gender Description</label>
                                                                        <input type="text" name="gender_description" class="form-control" value="{{$gender->gender_description}}">
                                                                    </div>
                                                                    <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary" value="Update">
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">There is no gender yet.</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <h3 class="card-title">Create New {{$name}}</h3>
                                <form class="form-material m-t-40" method="post" action="{{ route('gender.store')}}">
                                    @csrf
                                    <input type="hidden" name="type" value="{{ $type }}">
                                    <div class="form-group">
                                        <input type="text" name="gender_name" class="form-control @error('gender_name') is-invalid @enderror" placeholder="Enter {{$name}} Name" >
                                        @error('gender_name')
                                        <span class="invalid-feedback alert alert-danger" role="alert" height="100">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="gender_description" class="form-control" placeholder="Enter {{$name}} Description (Optional)">

                                    </div>
                                    <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary rounded" value="Add">
                                </form>
                            </div>
                        </div>
                    </div>
    @endif

@endsection


@section('js')
    <script>
    </script>
@endsection
