<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.11.3/datatables.min.css"/>
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@4.0.8/css/froala_editor.pkgd.min.css' rel='stylesheet' type='text/css' />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <?php if(isset($validation)):?>
            <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
        <?php endif;?>

        <?php if(session()->getFlashdata('error')):?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif;?>

        <h2>Hello,  <?= $auth->username ?></h2>
        <form action="/logout" method="post">
            <button type="submit" class="btn btn-primary">Logout</button>
        </form>




        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create">
                   + Artikel
                </button>
            </div>
            <div class="card-body">
                <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Thumbnail</th>
                        <th>Judul</th>
                        <th>Isi</th>
                        <th>Tag</th>
                        <th>Kategori</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@4.0.8/js/froala_editor.pkgd.min.js'></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.11.3/datatables.min.js"></script>
</body>


<!-- Modal -->
<div class="modal fade" id="create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">+ Artikel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formCreate">
                    <div class="mb-3">
                        <label  class="form-label">Judul</label>
                        <input type="text" class="form-control" name="judul">
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Isi</label>
                        <div id="isi"></div>
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Thumbnail</label>
                        <input type="file" class="form-control" name="thumbnail">
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Tag</label>
                        <input type="text" class="form-control" name="tag">
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Kategori</label>
                        <input type="text" class="form-control" name="kategori">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Buat</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Artikel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEdit">
                    <input type="text" id="id" class="form-control" name="id" hidden>
                    <div class="mb-3">
                        <label  class="form-label">Judul</label>
                        <input type="text" id="judul" class="form-control" name="judul">
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Isi</label>
                        <div id="isi2"></div>
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Thumbnail</label>
                        <input id="thumbnail" type="file" class="form-control" name="thumbnail">
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Tag</label>
                        <input id="tag" type="text" class="form-control" name="tag">
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Kategori</label>
                        <input id="kategori" type="text" class="form-control" name="kategori">
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Thumbnail</label>
                        <img width="100px" height="100px" id="gambar" scr="" />
                        <input type="file" class="form-control" name="thumbnail">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>

    var editor = new FroalaEditor('#isi', {
        toolbarButtons: ['undo', 'redo' , 'bold', 'italic', 'underline'],
        toolbarButtonsSM: ['undo', 'redo' , 'bold', 'italic', 'underline'],
        toolbarButtonsMD: ['undo', 'redo' , 'bold', 'italic', 'underline'],
        toolbarButtonsXS: ['undo', 'redo' , 'bold', 'italic', 'underline']
    });


    $('#formCreate').on('submit', function(e) {

            e.preventDefault();
            var formData = new FormData(this);
            formData.append('isi', editor.html.get())

            $.ajax({
                type: 'POST',
                url: '/dashboard/create',
                cache: false,
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    alert('Success');
                    Table.ajax.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error');
                }
            })
        })

    $('#formEdit').on('submit', function(e) {

        e.preventDefault();
        var formData = new FormData(this);
        formData.append('isi', editor2.html.get())

        $.ajax({
            type: 'POST',
            url: '/dashboard/edit',
            cache: false,
            processData: false,
            contentType: false,
            data: formData,
            success: function(data) {
                if(data.update === true){
                    Table.ajax.reload();
                    alert('Success');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error');
            }
        })
    })

    var Table = $('#table').DataTable({
        processing: true,
        serverSide: true,
        order: [], //init datatable not ordering
        ajax: "<?php echo site_url('/dashboard/indexDataTable')?>",
        columnDefs: [



        ],
    });

    function edit(id){

        $.ajax({
            url: "<?php echo site_url('/dashboard/getByID/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#id').val(data.id)
                $('#judul').val(data.judul_artikel)
                $('#tag').val(data.tag_artikel)
                $('#kategori').val(data.judul_artikel)
                $('#gambar').attr("src",'/public/uploads/'+data.thumbnail_artikel)
                editor2.html.set(data.isi_artikel);
                $('#edit').modal('show');

            }
        });
    }

    var editor2 = new FroalaEditor('#isi2', {
        toolbarButtons: ['undo', 'redo' , 'bold', 'italic', 'underline'],
        toolbarButtonsSM: ['undo', 'redo' , 'bold', 'italic', 'underline'],
        toolbarButtonsMD: ['undo', 'redo' , 'bold', 'italic', 'underline'],
        toolbarButtonsXS: ['undo', 'redo' , 'bold', 'italic', 'underline']
    });
</script>
</html>
