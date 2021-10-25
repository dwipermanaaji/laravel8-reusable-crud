<div class="row">
  @foreach ($forms as $item)
    <div class="form-group col-{{$item->colForm}}">
      @include('base-component.base-form-component.'.$item->type, ['forms' => $item])
    </div>
  @endforeach
</div>