<?php include('db_connect.php'); ?>
<?php

    $vote = $conn->query("SELECT * FROM voting_list where id=".$_GET['id']);
    foreach ($vote->fetch_array() as $key => $value) {
        $$key= $value;
    }
    $opts = $conn->query("SELECT * FROM voting_opt where voting_id=".$_GET['id']);
    $opt_arr = array();
    $set_arr = array();

    while($row=$opts->fetch_assoc()){
        $opt_arr[$row['category_id']][] = $row;
        $set_arr[$row['category_id']] = array('id'=>'','max_selection'=>1);
    }

    $settings = $conn->query("SELECT * FROM voting_cat_settings where voting_id=".$_GET['id']);
    while($row=$settings->fetch_assoc()){
        $set_arr[$row['category_id']] = $row;
    }

?>
<style>
    body {
        background-color: #f4f7fc;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
    }

    .card {
        border-radius: 0.75rem;
        margin-top: 30px;
    }

    .card-body {
        padding: 30px;
    }

    .text-center h3 {
        color: #0056b3;
        font-weight: 600;
    }

    .text-center small {
        color: #6c757d;
        font-size: 1rem;
    }

    .candidate {
        margin: auto;
        width: 20vw;
        padding: 15px;
        cursor: pointer;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        background-color: white;
        transition: transform 0.2s ease, box-shadow 0.3s ease;
        margin-bottom: 15px;
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .candidate:hover {
        background-color: #f7f7f7;
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
        transform: scale(1.05);
    }

    .candidate img {
        height: 150px;
        width: 150px;
        object-fit: cover;
        margin-right: 15px;
        border-radius: 0.5rem;
    }

    .candidate .text-center large {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
    }

    .candidate .info {
        margin-left: 15px;
    }

    .candidate .info .course-year {
        margin-top: 5px;
        font-size: 0.9rem;
        color: #555;
    }

    .candidate .rem_btn {
        position: absolute;
        top: -12px;
        right: -12px;
        z-index: 10;
    }

    .candidate .rem_btn .btn {
        background-color: #e74a3b;
        border: none;
        color: white;
        border-radius: 50%;
        padding: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }

    .candidate .rem_btn .btn:hover {
        background-color: #c0392b;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .edit_selection, .del_candidated {
        cursor: pointer;
        color: #007bff;
        font-size: 1.2rem;
        padding: 5px;
        border-radius: 50%;
    }

    .edit_selection:hover, .del_candidated:hover {
        color: #0056b3;
    }

    .edit_selection {
        margin-right: 10px;
    }

    .row.mt-3 {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
    }

    .row.mt-3 .candidate {
        width: 22vw;
        margin-bottom: 20px;
    }

    .card-header {
        background-color: #007bff;
        color: white;
        font-size: 1.25rem;
        font-weight: 600;
        padding: 15px;
        border-radius: 0.75rem 0.75rem 0 0;
    }

    .card-header small {
        font-size: 0.9rem;
        color: #dfe6e9;
    }

    .text-center h3,
    .candidate .text-center large {
        font-size: 1.2rem;
        font-weight: bold;
    }

    .text-center {
        margin-bottom: 20px;
    }

    .btn-outline-danger {
        border: 1px solid #e74a3b;
        color: #e74a3b;
    }

    .btn-outline-danger:hover {
        background-color: #e74a3b;
        color: white;
    }

    .modal-backdrop.show {
        opacity: 0.5;
    }

</style>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card mt-5">
            <div class="card-header text-center">
                <h1><b><?php echo $title ?></b></h1>
                <small><b><?php echo $description; ?></b></small>  
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-sm btn-primary float-right" type="button" id="new_opt">Add Candidate</button>
                    </div>
                </div>
                <?php 
                $cats = $conn->query("SELECT * FROM category_list where id in (SELECT category_id from voting_opt where voting_id = '".$_GET['id']."' )");
                while($row = $cats->fetch_assoc()):
                ?>
                    <hr>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="text-center">
                                <h3><b><?php echo $row['category'] ?></b></h3>
                                <span><a href="javascript:void(0)" class="edit_selection" data-id="<?php echo $set_arr[$row['id']]['id'] ?>" data-cid="<?php echo $row['id'] ?>" data-cname="<?php echo $row['category'] ?>" data-max="<?php echo $set_arr[$row['id']]['max_selection'] ?>" > <i class='fa fa-pen'></i></a></span>
                                <small>Max Selection: <b><?php echo $set_arr[$row['id']]['max_selection']; ?></b></small>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <?php foreach ($opt_arr[$row['id']] as $candidate) { ?>
                            <div class="candidate" style="position: relative;">
                                <span class="rem_btn"><button class="btn btn-rounded btn-sm btn-outline-danger del_candidated" data-id="<?php echo $candidate['id'] ?>"><i class="fa fa-trash"></i></button></span>
                                <div class="item"  data-id="<?php echo $candidate['id'] ?>">
                                    <div style="display: flex">
                                        <img src="assets/img/<?php echo $candidate['image_path'] ?>" alt="">
                                    </div>
                                    <div class="info">
                                        <large class="text-center"><b><?php echo ucwords($candidate['opt_txt']) ?></b></large>
                                        <div class="course-year">
                                            <p><b>Course:</b> <?php echo $candidate['course']; ?></p>
                                            <p><b>Year:</b> <?php echo $candidate['year']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<script>
    $('#new_opt').click(function(){
        uni_modal("New Candidate",'manage_opt.php?vid=<?php echo $_GET['id'] ?>')
    })
    $('.candidate>.item').click(function(){
        uni_modal("Edit Candidate",'manage_opt.php?vid=<?php echo $_GET['id'] ?>&id='+$(this).attr('data-id'))
    })
    $('.edit_selection').click(function(){
        uni_modal("Edit "+$(this).attr('data-cname')+" Category's Max Selection",'manage_catset.php?vid=<?php echo $_GET['id'] ?>&cid='+$(this).attr('data-cid')+'&max='+$(this).attr('data-max')+'&id='+$(this).attr('data-id'))
    })
    $('.del_candidated').click(function(e){
        e.preventDefault()
        _conf("Are you sure to delete this candidate?","delete_candidate",[$(this).attr('data-id')])
    })
    function delete_candidate($id){
        start_load()
        $.ajax({
            url:'ajax.php?action=delete_candidate',
            method:'POST',
            data:{id:$id},
            success:function(resp){
                if(resp==1){
                    alert_toast("Data successfully deleted",'success')
                    setTimeout(function(){
                        location.reload()
                    },1500)
                }
            }
        })
    }
</script>
