@extends('layouts.admin')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
              <h1 class="m-0">User</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">User</a></li>
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
                    <h3 class="card-title">Form Edit</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="quickForm" method="POST" action="{{route('pengaturan.user.update',$data->id)}}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                      <div class="row">
                        <div class="form-group col-6">
                            <label>Name<small class="text-danger">*</small></label>
                            {!! Form::text('name', $data->name, ['class'=>'form-control '.( $errors->has('name') ? ' is-invalid' : '' ),'placeholder'=>'Enter role name','required']) !!}
                            @error('name')
                                <span class="error invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-6">
                            <label>Email<small class="text-danger">*</small></label>
                            {!! Form::email('email', $data->email, ['class'=>'form-control '.( $errors->has('email') ? ' is-invalid' : '' ),'placeholder'=>'Enter email','required']) !!}
                            @error('email')
                                <span class="error invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-6">
                            <label>Password</label>
                            {!! Form::password('password', ['class'=>'form-control '.( $errors->has('password') ? ' is-invalid' : '' ),'placeholder'=>'Enter password']) !!}
                            @error('password')
                              <span class="error invalid-feedback">
                                {{ $message }}
                              </span>
                            @enderror
                        </div>
                        <div class="form-group col-6">
                          <label>Confirm Password</label>
                          {!! Form::password('password_confirmation', ['class'=>'form-control '.( $errors->has('password') ? ' is-invalid' : '' ),'placeholder'=>'Enter password']) !!}
                          @error('password')
                            <span class="error invalid-feedback">
                              {{ $message }}
                            </span>
                          @enderror
                        </div> 
                        <div class="form-group col-12">
                          <label>Role<small class="text-danger">*</small></label>
                          <div class="row ml-2 mr-2 mt-0">
                            @foreach ( $roles as $role )
                              <div class="form-check col-3">
                                {!! Form::checkbox( 'roles[]', 
                                                  $role->id,
                                                  $data->roles->count() > 0 ? in_array($role->id, $data->roles->pluck('id')->toarray()) : false,
                                                  ['class' => 'form-check-input', 'id' => 'role'.$role->id] 
                                                  ) !!}
                                {!! Form::label('role'.$role->id,  $role->name,['class'=>'form-check-label']) !!}
                              </div>
                            @endforeach
                          </div>
                          @error('roles')
                            <span class="text-danger">
                              {{ $message }}
                            </span>                            
                          @enderror                          
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
