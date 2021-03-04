<?php
if( !session_id() ) @session_start();

use Tamtamchik\SimpleFlash\Flash;

$this->layout('layout', ['title' => 'User Profile']) ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
</head>

<body>


<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <br>
            <a href="/create" class="btn btn-success">Add new user</a>
            <hr>
            <?php if(Flash::hasMessages('success')):?>
                <?php echo Flash::display('success');?>
            <?php endif;?>
            <?php if(Flash::hasMessages('error')):?>
                <?php echo Flash::display('error');?>
            <?php endif;?>
            <table class="table">
                <thead class="table">
                <th>#</th>
                <th>User name</th>
                <th>Email</th>
                <th></th>
                <th></th>
                </thead>
                <tbody>

                <?php foreach ($postsInView as $user):?>
                    <tr>
                        <td><?php echo $user['id'];?></td>
                        <td><a href="/edit/<?php echo $user['id'];?><"><?php echo $user['username'];?></a></td>
                        <td><?php echo $user['email'];?></td>
                        <td><a href="/edit/<?php echo $user['id'];?>" class="btn btn-warning">Edit</a></td>
                        <td><a href="/delete/<?php echo $user['id'];?>" class="btn btn-danger" onclick="return confirm('Delete this user?');">Delete</a></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
</script>
</body>

</html>

