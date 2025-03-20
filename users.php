<?php 
include 'db_connect.php';
?>

<style>
    body {
        background-color: #f8f9fa; /* Light gray background */
    }
    .card {
        background-color: #ffffff; /* White card background */
    }
</style>

<div class="container-fluid py-3">
    <div class="row mb-3">
        <div class="col-lg-12 d-flex justify-content-end">
            <button class="btn btn-success btn-sm" id="new_user">
                <i class="fa fa-plus"></i> Add New User
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">User Management</h4>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-bordered text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $users = $conn->query("SELECT * FROM users ORDER BY name ASC");
                            $i = 1;
                            while ($row = $users->fetch_assoc()):
                            ?>
                            <tr id="user-<?php echo $row['id']; ?>">
                                <td><?php echo $i++; ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-secondary btn-sm edit_user" 
                                            data-id="<?php echo $row['id']; ?>">Edit</button>
                                        <button type="button" class="btn btn-danger btn-sm delete_user" 
                                            data-id="<?php echo $row['id']; ?>">Delete</button>
                                    </div>
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

<script>
    $(document).ready(function() {
        $('#new_user').click(function() {
            uni_modal('New User', 'manage_user.php');
        });

        $('.edit_user').click(function() {
            uni_modal('Edit User', 'manage_user.php?id=' + $(this).data('id'));
        });

        $('.delete_user').click(function() {
            var userId = $(this).data('id');
            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    url: 'delete_user.php',
                    type: 'POST',
                    data: { id: userId },
                    success: function(response) {
                        if (response === "success") {
                            $('#user-' + userId).fadeOut();
                            alert_toast('User deleted successfully!', 'success');
                        } else {
                            alert_toast('Failed to delete user!', 'danger');
                        }
                    }
                });
            }
        });
    });
</script>
