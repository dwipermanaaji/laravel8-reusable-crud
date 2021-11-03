@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Trash {{$info->title}}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route($info->routes['index'])}}">{{$info->title}}</a></li>
                            <li class="breadcrumb-item active">Trash</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex ">
                                <h3 class="card-title d-flex align-items-center">Table Data Trash {{$info->title}}</h3>
                                <a href="{{ route($info->routes['index']) }}" class="btn btn-default ml-auto">Back</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                              @include('base-component.base-view-component.datatable')
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

@push('script')
    @include('base-component.base-view-component.script-datatable')

    <script text="javascript">

    </script>    
@endpush
