@php
    $parameter = [];
    if($info->routes['trash'] == Route::currentRouteName()){
        $parameter['trash'] = true;
    }
@endphp

<script type="text/javascript">
    function deletePermanent(token) {
        Swal.fire({
            title: "Yakin akan dihapus Permanen?",
            text: "Setelah dihapus Permanen data tidak bisa dikembalikan.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
        }).then(function(result) {
            if (result.value) {
                event.preventDefault();
                document.getElementById('form-delete-' + token).submit();
            }
        });
    }

    function deleteData(token) {
        console.log(token);
        Swal.fire({
            title: "Yakin akan dihapus?",
            text: "Setelah dihapus data tidak akan tampil di aplikasi.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
        }).then(function(result) {
            if (result.value) {
                event.preventDefault();
                document.getElementById('form-delete-' + token).submit();
            }
        });
    }
    function restore(token) {
        Swal.fire({
            title: "Yakin akan direstore?",
            text: "Setelah direstore data akan kembali.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Restore!",
            cancelButtonText: "Batal"
        }).then(function(result) {
            if (result.value) {
                event.preventDefault();
                document.getElementById('form-restore-' + token).submit();
            }
        });
    }

  $(document).ready(function(){
      var route = "{{ route($info->routes['dataTable'],$parameter) }}";
      const parseResult = new DOMParser().parseFromString(route, "text/html");
      const parsedUrl = parseResult.documentElement.textContent;

      $('#dataTable').DataTable({
          processing: true,
          serverSide: true,
          order: [], 
          ajax: {
              "url": parsedUrl,
              "dataType": "json",
              "type": "get",
          },
          columns: [
              @foreach($info->datatableColumn as $item)
                  {
                      "data":"{{ $item['data'] }}",
                      "name":"{{ $item['data'] }}",
                      "orderable": {{ $item['orderable'] === true ? 'true' : 'false' }},
                      "searchable": {{ $item['searchable'] === true ? 'true' : 'false' }},
                      "className":"{{ $item['data'] == 'action' ? 'text-center' : '' }}",
                  },
              @endforeach
          ],
      });
  });
</script>

