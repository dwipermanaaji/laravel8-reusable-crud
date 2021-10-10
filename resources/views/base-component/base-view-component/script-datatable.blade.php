<script type="text/javascript">
    function deletePengaduan(token) {
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

  $(document).ready(function(){
      var route = "{{ route($info->routes['dataTable']) }}";
      const parseResult = new DOMParser().parseFromString(route, "text/html");
      const parsedUrl = parseResult.documentElement.textContent;

      $('#dataTable').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
              "url": parsedUrl,
              "dataType": "json",
              "type": "get",
          },
          columns: [
              @foreach($info->datatableRows as $item)
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

