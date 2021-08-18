<?php
$conn = new PDO('mysql:host=localhost;dbname=tables', 'root', '');

$rowcount = 1;

if (isset($_REQUEST['btn_submit'])) {

    if ($_REQUEST['btn_submit'] == 'Submit') {

        $rowcount = $_POST["rowcount"];

        for ($i = 0; $i < $rowcount; $i++) {

            $field1 = $_POST['field1'][$i];
            $field2 = $_POST['field2'][$i];
            $field3 = $_POST['field3'][$i];

            $sql = "INSERT INTO tables (field1,field2,field3)VALUES (:field1,:field2,:field3)";
            $query = $conn->prepare($sql);

            $query->bindParam(':field1', $field1, PDO::PARAM_STR);
            $query->bindParam(':field2', $field2, PDO::PARAM_STR);
            $query->bindParam(':field3', $field3, PDO::PARAM_STR);

            $query->execute();
        }

        echo "<script type='text/javascript'>alert('Succesfull!!!');window.location='./tables.php';</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        table {
            counter-reset: Serial;
        }

        .dataTable td:first-child:before {
            counter-increment: Serial;
            /* Increment the Serial counter */
            content: counter(Serial);
            /* Display the counter */
        }

        .sinput {
            letter-spacing: 2px;
        }

        .dataTable td:nth-child(1) {
            text-align: center;
        }

        .dataTable td:nth-child(2) {
            text-align: left;
        }

        .dataTable td:nth-child(2) h6,
        .dataTable td select {
            width: max-content;
        }

        .dataTable tr td:first-child:before {
            counter-increment: Serial;
            /* Increment the Serial counter */
            content: counter(Serial);
            /* Display the counter */
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <h1 align="center">Dynamic Table Using HTML, PHP and MySql</h1>
    <form action="#" method="post">

        <!-- ROW COUNTS -->
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <label>Row Count</label>
                    <input type="text" name="rowcount" class="form-control" id="rowcount" value="<?php echo $rowcount ?>" readonly>
                </div>
            </div>

            <table class="display table table-responsive-xl dataTable  mt-4">
                <thead class="table-dark">
                    <tr>
                        <th>Sr No.</th>
                        <th>Field 1</th>
                        <th>Field 2</th>
                        <th>Field 3</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody id="dataTable">

                    <?php for ($i = 0; $i < $rowcount; $i++) { ?>

                        <tr class="table_attach">
                            <td></td>
                            <td align="center">
                                <input class="form-control " type="text" name="field1[]" id="field1">
                            </td>
                            <td align="center">
                                <input class="form-control " type="text" name="field2[]" id="field2">
                            </td>
                            <td align="center">
                                <input class="form-control " type="text" name="field3[]" id="field3">
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-success" onclick="addRow(this)">+</button>
                            </td>
                            <td><br></td>
                        </tr>

                    <?php } ?>

                </tbody>

            </table>

            <center>
                <div class="col-xl-1 col-md-1">
                    <input type="submit" class="btn btn-block btn-outline-success" name="btn_submit" id="submit" value="Submit" />
                </div>
            </center>

        </div>

    </form>


    <script>
        function addRow(e) {


            var rowcount = document.getElementById("rowcount").value;

            var table = document.getElementById("dataTable");

            var rowIndex = e.closest('tr').rowIndex;

            var row = table.insertRow(rowIndex);

            row.innerHTML = "<tr class='table_attach'> <td></td> <td align='center'> <input class='form-control ' type='text' name='field1[]' id='field1'  > </td> <td align='center'> <input class='form-control ' type='text' name='field2[]' id='field2'  > </td> <td align='center'> <input class='form-control ' type='text' name='field3[]' id='field3'  > </td> <td > <button type='button' class='btn btn-sm btn-success' onclick='addRow(this)'>+</button> </td><td> <button type='button' class='btn btn-sm btn-danger btnRemove'>-</button> </td> </tr>";
            document.getElementById("rowcount").value = parseInt(rowcount) + 1;


        }

        $(document).ready(function() {

            $(document).on("click", ".btnRemove", function(e) {

                var rowcount = document.getElementById("rowcount").value;

                var table = document.getElementById("dataTable");
                const btn = e.target;
                var rowIndex = btn.closest('tr').rowIndex;
                document.getElementById("rowcount").value = parseInt(rowcount) - 1;
                btn.closest("tr").remove();
            });

        });
    </script>
</body>

</html>