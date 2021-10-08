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
                            <form id="quickForm" method="POST" action="12312">
                                <div class="card-body">
                                  <div class="row">
                                    <div class="form-group col-6">
                                        <label>Role Name</label>
                                        {!! Form::email('name', null, ['class'=>'form-control '.( $errors->has('name') ? ' is-invalid' : '' ),'placeholder'=>'Enter role name']) !!}
                                        @error('name')
                                            <span class="error invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Guard Name</label>
                                        {!! Form::email('guard_name', 'web', ['class'=>'form-control '.( $errors->has('guard_name') ? ' is-invalid' : '' ),'placeholder'=>'Enter guard name','readonly']) !!}
                                        @error('guard_name')
                                            <span class="error invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Premission</label>
                                        @php
                                            $working_days = array( 0 => 'Mon', 1 => 'Tue', 2 => 'Wed',3 => 'Thu', 4 => 'Fri', 5 => 'Sat', 6 => 'Sun' );
                                            $arrayToSearch = array("Mon");
                                        @endphp
                                        {{-- {!! Form::email('guard_name', 'web', ['class'=>'form-control '.( $errors->has('guard_name') ? ' is-invalid' : '' ),'placeholder'=>'Enter guard name','readonly']) !!} --}}
                                        {{-- {!! Form::checkbox('premission[]', 1, ['1'], ['class'=>'form-control']) !!} --}}
@foreach ( $working_days as $i => $working_day )
{{dd(!in_array($working_days[$i],$arrayToSearch))}}
{!! Form::checkbox( 'working_days[]', 
                  $working_day,
                  !in_array($working_days[$i],$arrayToSearch),
                  ['class' => 'md-check', 'id' => $working_day] 
                  ) !!}
{!! Form::label($working_day,  $working_day) !!}
@endforeach
                                        @error('guard_name')
                                            <span class="error invalid-feedback">
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
