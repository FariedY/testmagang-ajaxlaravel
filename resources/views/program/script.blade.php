<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            processing:true,
            serverside:true,
            ajax:"{{ url('programAjax') }}",
            columns:[{
                data:'DT_RowIndex',
                name:'DT_RowIndex',
                orderable:false,
                searchable:false
            },{
                data:'sumber_dana',
                name:'Sumber Dana'

            },{
                data:'data_program',
                name:'Data Program'
            },{
                data:'keterangan',
                name:'Keterangan'
            },{
                data:'aksi',
                name:'Aksi'
            }]
        });
    });

    // GLOBAL SETUP
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    // 02_PROSES SIMPAN
    $('body').on('click','.tombol-tambah', function(e) {
        e.preventDefault();
        $('#exampleModal').modal('show');
        $('.tombol-simpan').click(function() {
            simpan();
        });
    });

    // 03_PROSES EDIT
    $('body').on('click','.tombol-edit', function(e) {
        var id = $(this).data('id');
        $.ajax({
            url: 'programAjax/' + id + '/edit',
            type: 'GET',
            success: function(response){
                $('#exampleModal').modal('show');
                $('#sumber_dana').val(response.result.sumber_dana);
                $('#data_program').val(response.result.data_program);
                $('#keterangan').val(response.result.keterangan);
                console.log(response.result);
                $('.tombol-simpan').click(function() {
                    simpan(id);
                });
            }
        });

    });

    // 04_PROSES delete
    $('body').on('click','.tombol-del', function(e) {
        if(confirm('yakin ingin menghapus data ini?') == true){
            var id = $(this).data('id');
            $.ajax({
                url: 'programAjax/' + id,
                type: 'DELETE',
            });
            $('#myTable').DataTable().ajax.reload();
        }
    });

    // fungsi simpan dan update
    function simpan(id = '') {
        if(id == '') {
            var var_url = 'programAjax';
            var var_type = 'POST';
        } else {
            var var_url = 'programAjax/' + id;
            var var_type = 'PUT';
        }
        $.ajax({
                url: var_url,
                type: var_type,
                data:{
                    sumber_dana: $('#sumber_dana').val(),
                    data_program: $('#data_program').val(),
                    keterangan: $('#keterangan').val()
                },
                success:function(response){
                    if(response.errors){
                        console.log(response.errors);
                        $('.alert-danger').removeClass('d-none');
                        $('.alert-danger').append("<ul>");
                        $.each(response.errors, function(key, value) {
                            $('.alert-danger').find('ul').append("<li>" + value + "</li>");
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

    $('#exampleModal').on('hidden.bs.modal', function() {
        $('#sumber_dana').val('');
        $('#data_program').val('');
        $('#keterangan').val('');

        $('.alert-danger').addClass('d-none');
        $('.alert-danger').html('');

        $('.alert-success').addClass('d-none');
        $('.alert-success').html('');
    });
</script>
