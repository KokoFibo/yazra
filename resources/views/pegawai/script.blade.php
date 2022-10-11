<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('pegawaiAjax') }}",
            columns: [{
                    // data: 'DT_RowIndex',
                    // name: 'DT_RowIndex',
                    // orderable: false,
                    // searchable: false
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
                        console.log(response.errors);
                        $('.alert-danger').removeClass('d-none');
                        $('.alert-danger').html('<ul>');

                        $.each(response.errors, function(key, value) {
                            $('.alert-danger').find('ul').append(
                                "<li>" + value +
                                "</li>");
                        });
                        $('.alert-danger').append("</ul>");

                    } else {
                        $('.alert-success').removeClass('d-none');
                        $('.alert-success').html(response.success);


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
                    console.log(response.result);
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
            if (confirm('Yakin mau hapus data ini?') == true) {
                let id = $(this).data('id');
                $.ajax({
                    url: 'pegawaiAjax/' + id,
                    type: 'DELETE',
                });
                $('#myTable').DataTable().ajax.reload();
            }
        });




        // Close Modal
    });
    $('#exampleModal').on('hidden.bs.modal', function() {
        $('#nama').val('');
        $('#email').val('');
        $('.alert-danger').addClass('d-none');
        $('.alert-danger').html('');
        $('.alert-success').addClass('d-none');
        $('.alert-success').html('');
    });
</script>
