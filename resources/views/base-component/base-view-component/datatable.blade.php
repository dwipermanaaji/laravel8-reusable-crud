<table id="dataTable" class="table table-bordered table-striped">
  <thead>
      <tr>
        @foreach ($info->datatableColumn as $item)
            {{ !isset($item['data']) ? dd('rows[data] harap di isi') : ''  }}
            <th
                {{ isset($item['width']) ? 'width='.$item['width'].'' : '' }}
                class="bg-default"
            >
                {{ isset($item['title']) ? $item['title'] : $item['data'] }}
            </th>
        @endforeach
      </tr>
  </thead>
  <tbody>

  </tbody>
</table>