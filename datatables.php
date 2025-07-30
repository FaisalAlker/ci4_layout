<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css" rel="stylesheet">
</head>
<body>

<table id="myTable" class="display table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= $user['email'] ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<!-- jQuery: load BEFORE DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        console.log('on loaded');
        $('#myTable').DataTable(
            {
                paging: true,
                searching: true,
                ordering: true,
                info: true,
            }
        ); // You can pass options here if needed

        
    });
</script>

</body>
</html>
