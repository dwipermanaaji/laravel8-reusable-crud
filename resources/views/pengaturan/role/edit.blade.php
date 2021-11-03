@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Role</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Role</a></li>
                            <li class="breadcrumb-item active">Form Edit</li>
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
                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Form Edit <small>({{$data->name}})</small></h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="quickForm" method="POST" action="{{route('pengaturan.role.update',$data->id)}}">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                  <div class="row">
                                    <div class="form-group col-6">
                                        <label>Role Name</label>
                                        {!! Form::text('name', $data->name, ['class'=>'form-control '.( $errors->has('name') ? ' is-invalid' : '' ),'placeholder'=>'Enter role name']) !!}
                                        @error('name')
                                            <span class="error invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Guard Name</label>
                                        {!! Form::email('guard_name', $data->guard_name, ['class'=>'form-control '.( $errors->has('guard_name') ? ' is-invalid' : '' ),'placeholder'=>'Enter guard name','readonly']) !!}
                                        @error('guard_name')
                                            <span class="error invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Premission</label>
                                        <div class="row ml-2 mr-2 mt-0">
                                            @foreach ($modulePermissions as $modulePermission)
                                                <div class="col-12 card direct-chat-primary">
                                                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                                                    <h3 class="card-title">{{$modulePermission->module_name}}</h3>
                                                    <div class="card-tools">
                                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                        <i class="fas fa-minus"></i>
                                                        </button>
                                                    </div>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <div class="card-body " style="display: block">
                                                        <div class="row">
                                                            @foreach ($modulePermission->sub_module_permissions as $sub_module_permission)                                                        
                                                                <div class="col-6" >
                                                                    <b>{{$sub_module_permission->sub_module_name}}</b>
                                                                    @foreach ( $sub_module_permission->permissions as $i => $permission )
                                                                    <div class="form-check col-12 ml-2">
                                                                        {!! Form::checkbox( 'permissions[]', 
                                                                        $permission->id,
                                                                        $data->permissions->count() > 0 ? in_array($permission->id, $data->permissions->pluck('id')->toarray()) : false,
                                                                        ['class' => 'form-check-input', 'id' => 'permission'.$permission->id] 
                                                                        ) !!}
                                                                        {!! Form::label('permission'.$permission->id,  $permission->name,['class'=>'form-check-label']) !!}
                                                                    </div>
                                                                    @endforeach                                                          
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                          </div>                                        
                                    </div>  
                                  </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div><!-- /.card -->
                    </div><!--/.col (left) -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@push('script')

@endpush
