<label>
  {{$forms->label}}
  @if (isset($forms->option['required']))
    <span class="text-danger">*</span>
  @endif
</label>
@php
  $option = $forms->option;
  $invalid = ($errors->has($forms->name)) ? ' is-invalid ' : '';
  $option = (!isset($option['class'])) ? array_merge($option, ['class'=>'']) : $forms->option;
  $option['class'] = $option['class'].$invalid;
  $value = (isset($obj[$forms->name])) ? $obj[$forms->name]: $forms->value;
  $value = ($forms->selected != null) ? $forms->selected : $value;
@endphp
{!! Form::select($forms->name, $forms->list, $value, $option) !!}
@error($forms->name)
    <span class="error invalid-feedback">
        {{ $message }}
    </span>
@enderror