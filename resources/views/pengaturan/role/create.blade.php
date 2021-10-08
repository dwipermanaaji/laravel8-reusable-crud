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
                            <li class="breadcrumb-item active">Form Create</li>
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
                                <h3 class="card-title">Form Create</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="quickForm" method="POST" action="{{route('pengaturan.role.store')}}">
                              @csrf
                              <div class="card-body">
                                <div class="row">
                                  <div class="form-group col-6">
                                      <label>Role Name<small>*</small></label>
                                      {!! Form::text('name', null, ['class'=>'form-control '.( $errors->has('name') ? ' is-invalid' : '' ),'placeholder'=>'Enter role name','required']) !!}
                                      @error('name')
                                          <span class="error invalid-feedback">
                                              {{ $message }}
                                          </span>
                                      @enderror
                                  </div>
                                  <div class="form-group col-6">
                                      <label>Guard Name<small>*</small></label>
                                      {!! Form::email('guard_name', 'web', ['class'=>'form-control '.( $errors->has('guard_name') ? ' is-invalid' : '' ),'placeholder'=>'Enter guard name','readonly','required']) !!}
                                      @error('guard_name')
                                          <span class="error invalid-feedback">
                                              {{ $message }}
                                          </span>
                                      @enderror
                                  </div>
                                  <div class="form-group col-12">
                                      <label>Premission</label>
                                      <div class="row ml-2 mr-2 mt-0">
                                        @foreach ( $permissions as $i => $permission )
                                        <div class="form-check col-3">
                                          {!! Form::checkbox( 'permissions[]', 
                                                            $permission->id,
                                                            false,
                                                            ['class' => 'form-check-input', 'id' => 'permission'.$permission->id] 
                                                            ) !!}
                                          {!! Form::label('permission'.$permission->id,  $permission->name,['class'=>'form-check-label']) !!}
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