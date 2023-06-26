
<script>
    $(document).ready(function() {
      $("#logout").on("click", function() {
          $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('logout')}}",
                type:"POST",
            }).done(function(resp) {
              if (resp['result'] == true) {
                window.location.href = resp['redirect'];
              }
            })
        })
    });
</script>