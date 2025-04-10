<?php include('db_connect.php'); ?>

<style>
    body {
        background-color: #e3f2fd; /* Softer blue background */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card {
        border: none;
        border-radius: 0.75rem;
    }

    .card-header {
        font-weight: 600;
        font-size: 1.2rem;
        background-color: #007bff;
        color: white;
        border-top-left-radius: 0.75rem;
        border-top-right-radius: 0.75rem;
    }

    .btn {
        font-size: 14px;
        padding: 8px 16px;
        border-radius: 0.5rem;
        transition: background-color 0.3s, box-shadow 0.3s;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
    }

    .btn-danger:hover {
        background-color: #c82333;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-info {
        background-color: #17a2b8;
        border: none;
    }

    .btn-info:hover {
        background-color: #138496;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .form-group label {
        font-weight: 500;
    }

    .table th, .table td {
        text-align: center;
        vertical-align: middle !important;
    }

    .badge {
        padding: 0.5em 0.75em;
        font-size: 90%;
        border-radius: 0.5rem;
    }

    /* Styling the title button */
    .table td button.btn-title {
        background-color: #f8f9fa;
        border: 1px solid #007bff;
        color: #007bff;
        padding: 6px 12px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        border-radius: 0.5rem;
        transition: background-color 0.3s, color 0.3s;
    }

    .table td button.btn-title:hover {
        background-color: #007bff;
        color: white;
    }

    .update_default {
        cursor: pointer;
        color: #007bff;
        text-decoration: underline;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }

    .table th, .table td {
        padding: 1rem;
    }

    .btn + .btn {
        margin-left: 0.5rem;
    }

</style>

<div class="container-fluid mt-4">
    <div class="row">
        <!-- FORM Panel -->
        <div class="col-md-4 mb-4">
            <form action="" id="manage-voting">
                <div class="card shadow-sm">
                    <div class="card-header">Candidates Form</div>
                    <div class="card-body">
                        <input type="hidden" name="id">
                        <div class="form-group">
                            <label for="title">Position</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter Position" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" placeholder="Enter Description" required rows="3"></textarea>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-sm btn-primary">Save</button>
                        <button class="btn btn-sm btn-secondary" type="button" onclick="$('#manage-voting').get(0).reset()">Cancel</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Table Panel -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">Candidates Position</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>No.</th>
                                    <th>Position</th>
                                    <th>Description</th>
                                    <th>Default</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                $vote = $conn->query("SELECT * FROM voting_list ORDER BY id ASC");
                                while ($row = $vote->fetch_assoc()):
                                ?>
                                <tr>
                                    <td><?php echo $i++ ?></td>
                                    <td>
                                        <button class="btn btn-title">
                                            <a href="index.php?page=manage_voting&id=<?php echo $row['id'] ?>" style="color: inherit; text-decoration: none;">
                                                <?php echo htmlspecialchars($row['title']) ?>
                                            </a>
                                        </button>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['description']) ?></td>
                                    <td>
                                        <?php if ($row['is_default'] == 1): ?>
                                            <span class="badge badge-success">Yes</span>
                                        <?php else: ?>
                                            <span class="badge badge-info update_default" data-id="<?php echo $row['id'] ?>">No</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary edit_voting" type="button" data-id="<?php echo $row['id'] ?>">Edit</button>
                                        <button class="btn btn-sm btn-danger delete_voting" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#manage-voting').submit(function(e){
        e.preventDefault();
        start_load();
        $.ajax({
            url:'ajax.php?action=save_voting',
            method:'POST',
            data:$(this).serialize(),
            success:function(resp){
                if(resp==1){
                    alert_toast("Data successfully added",'success');
                    setTimeout(function(){ location.reload(); },1500);
                }
                else if(resp==2){
                    alert_toast("Data successfully updated",'success');
                    setTimeout(function(){ location.reload(); },1500);
                }
            }
        });
    });

    $('.edit_voting').click(function(){
        start_load();
        var cat = $('#manage-voting');
        var _this = $(this);
        cat.get(0).reset();
        $.ajax({
            url:'ajax.php?action=get_voting',
            method:'POST',
            data:{id:_this.attr('data-id')},
            success:function(resp){
                if(typeof resp != undefined){
                    resp = JSON.parse(resp);
                    cat.find('[name="id"]').val(_this.attr('data-id'));
                    cat.find('[name="title"]').val(resp.title);
                    cat.find('[name="description"]').val(resp.description);
                    end_load();
                }
            }
        });
    });

    $('.update_default').click(function(){
        _conf("Are you sure to set this data as default?","update_default",[$(this).attr('data-id')]);
    });

    $('.delete_voting').click(function(){
        _conf("Are you sure to delete this data?","delete_voting",[$(this).attr('data-id')]);
    });

    function update_default(id){
        start_load();
        $.ajax({
            url:'ajax.php?action=update_voting',
            method:'POST',
            data:{id:id},
            success:function(resp){
                if(resp == 1){
                    alert_toast("Data successfully updated",'success');
                    setTimeout(function(){ location.reload(); },1500);
                }
            }
        });
    }

    function delete_voting(id){
        start_load();
        $.ajax({
            url:'ajax.php?action=delete_voting',
            method:'POST',
            data:{id:id},
            success:function(resp){
                if(resp == 1){
                    alert_toast("Data successfully deleted",'success');
                    setTimeout(function(){ location.reload(); },1500);
                }
            }
        });
    }
</script>
