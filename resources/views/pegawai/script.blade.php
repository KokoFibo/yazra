<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('pegawaiAjax') }}",
            columns: [{

                    data: 'id',
                    name: 'Id',
                    // orderable: false,
                    searchable: false
                },
                {
                    data: 'nama',
                    name: 'Nama'
                },
                {
                    data: 'email',
                    name: 'Email'
                },
                {
                    data: 'aksi',
                    name: 'Aksi',
                    orderable: false,
                    searchable: false
                },
            ],
        });
        // Global CSRF setup

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Tambah data
        $('body').on('click', '.tombol-tambah', function(e) {
            e.preventDefault();
            $('#exampleModal').modal('show');

            $('.tombol-simpan').click(function() {
                simpan();
            });
        })

        // function Simpan

        function simpan(id = '') {

            if (id == '') {
                var var_url = 'pegawaiAjax';
                var var_type = 'POST';
            } else {
                var var_url = 'pegawaiAjax/' + id;
                var var_type = 'PUT';
            }
            $.ajax({
                url: var_url,
                type: var_type,
                data: {
                    nama: $('#nama').val(),
                    email: $('#email').val(),
                },


                success: function(response) {
                    if (response.errors) {
                        alert('error :' + email)
                        $('.alert-danger').removeClass('d-none');
                        $('.alert-danger').html('<ul>');

                        $.each(response.errors, function(key, value) {
                            $('.alert-danger').find('ul').append(
                                "<li>" + value +
                                "</li>");
                        });
                        $('.alert-danger').append("</ul>");

                    } else {

                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Your work has been saved lho',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        clearData();
                        $('.btn-close').click();
                    }
                    $('#myTable').DataTable().ajax.reload();
                }
            });
        }

        // Edit Data
        $('body').on('click', '.tombol-edit', function(e) {
            let id = $(this).data('id');
            $.ajax({
                url: 'pegawaiAjax/' + id + '/edit',
                type: 'get',
                success: function(response) {
                    // console.log(response.result);
                    $('#exampleModal').modal('show');
                    $('#nama').val(response.result.nama);
                    $('#email').val(response.result.email);
                    $('.tombol-simpan').click(function() {
                        simpan(id);
                    });
                }
            });
        });

        //Proses Delete
        $('body').on('click', '.tombol-del', function(e) {

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let id = $(this).data('id');
                    $.ajax({
                        url: 'pegawaiAjax/' + id,
                        type: 'DELETE',
                    });
                    $('#myTable').DataTable().ajax.reload();
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            })
        });




        // Close Modal
    });

    function clearData() {
        $('#nama').val('');
        $('#email').val('');
        $('.alert-danger').addClass('d-none');
        $('.alert-danger').html('');
        $('.alert-success').addClass('d-none');
        $('.alert-success').html('');
    }
    $('#exampleModal').on('hidden.bs.modal', function() {
        clearData();
    });
</script>
