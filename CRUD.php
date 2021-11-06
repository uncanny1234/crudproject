<?php
$insert = false;
$delete = false;
$update = false;
//connection to database
$servername = "localhost";
$username = "root";
$password = "";
$database = "crud";
$conn = mysqli_connect($servername,$username,$password,$database);
if (!$conn){
    die("Sorry we failed to connect: ".mysqli_connect_error());
}
/*
insert data into database
print_r ($_POST);
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
  // print_r ($_GET);
  if(isset($_GET['delete'])){
    $deleteid = $_GET['delete'];
    $sql = "DELETE FROM `user` WHERE `sno` = $deleteid";
    $result = mysqli_query($conn,$sql);
    if($result){
        $delete=true;
    }
  }else{}
  
  // if(isset($_GET['edit'])){
  //   $editid = $_GET['edit'];
  //   $sql = "UPDATE `user` SET `first_name` = '$first_name', `last_name` = '$last_name' WHERE `sno` = $editid;";
  //   $result = mysqli_query($conn,$sql);
  //   if($result){
  //       $edit=true;
  //   }
  // }
}else{
    */
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // $first_name = $_POST["first_name"];
    // $last_name = $_POST["last_name"];
    if (isset($_POST["first_name"], $_POST["last_name"])){ //insert Data 
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $sql = "INSERT INTO `user` (`fname`, `lname`) VALUES ('$first_name', '$last_name')";
        $result = mysqli_query($conn,$sql);
            if($result){
                $insert=true;
            }
    }elseif(isset($_POST["edit_sNo"], $_POST["edit_first_name"], $_POST["edit_last_name"])){ //Edit data
        $edit_sNo = $_POST["edit_sNo"];
        $edit_first_name = $_POST["edit_first_name"];
        $edit_last_name = $_POST["edit_last_name"];
        $sql = "UPDATE `user` SET `fname` = '$edit_first_name', `lname` = '$edit_last_name' WHERE `sno` = $edit_sNo;";
        $result = mysqli_query($conn,$sql);
            if($result){
                $update=true;
            }
    }elseif(isset($_POST["delete_sNo"])){ // Delete Data
        $delete_sNo = $_POST["delete_sNo"];
        // $delete_first_name = $_POST["delete_first_name"];
        // $delete_last_name = $_POST["delete_last_name"];
        $sql = "DELETE FROM `user` WHERE `sno` = $delete_sNo";
        $result = mysqli_query($conn,$sql);
            if($result){
                $delete=true;
            }
    }
}
// }
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">

    <title>CRUD</title>
</head>

<body>
<!-- Edit Modal -->
    <!-- Button trigger modal -->
    <!-- check bootstrap version, use data-bs-toggle, data-bs-target, data-bs-dismiss instead of data-toggle, data-target, data-dismiss in Bootstrap Version 5 -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
        Launch demo modal
      </button>                            -->

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/crud/CRUD.php" method="POST">
                    <input type="hidden" class="form-control " id="edit_sNo" name="edit_sNo" required>
                        <div class="form-group">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="edit_first_name" name="edit_first_name" required>

                        </div>
                        <div class="form-group">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="edit_last_name" name="edit_last_name" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                        <!-- <button  type="submit" class="btn btn-primary mt-3 mb-3">Submit</button> -->

                    </form>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> -->
            </div>
        </div>
    </div>
<!-- Edit Modal End -->

<!-- Delete Modal -->
    <!-- Button trigger modal -->
    <!-- check bootstrap version, use data-bs-toggle, data-bs-target, data-bs-dismiss instead of data-toggle, data-target, data-dismiss in Bootstrap Version 5 -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
        Launch demo modal
      </button>                            -->

    <!--  Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you want to Delete this record?</p>
                    <form action="/crud/CRUD.php" method="POST">
                        
                        <input type="hidden" class="form-control " id="delete_sNo" name="delete_sNo" required>
                        <fieldset disabled>
                            <div class="form-group" ">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control " id="delete_first_name" name="delete_first_name" required>

                            </div>
                            <div class="form-group">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control " id="delete_last_name" name="delete_last_name" required>
                            </div>
                        </fieldset>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                 <button type="submit" class="btn btn-primary">Delete</button>
                            </div>
                        <!-- <button  type="submit" class="btn btn-primary mt-3 mb-3">Submit</button> -->

                    </form>
                </div>
                
            </div>
        </div>
    </div>
<!-- Delete Modal End -->
    <!-- Nav bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/crud/CRUD.php">CRUD</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/crud/CRUD.php">Home</a>
                    </li>
                    <!-- <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li> -->
                    <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li> -->
                    <!-- <li class="nav-item">
          <a class="nav-link disabled">Disabled</a>
        </li> -->
                </ul>
               
            </div>
        </div>
    </nav>
    <!-- nav bar end -->
    <div class="container my-5">
        <div class="container col-8"><?php 
    if($insert){ //insert data message
        echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>success!</strong> Your name inserted successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    if($update){ //edit data message
        echo"<div class='alert alert-warning alert-dismissible fade show' role='alert'>
        <strong>success!</strong> Record updated successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    if($delete){ //delete data message
        echo"<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>success!</strong> Record deleted successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
?>
    <!-- Form start -->
        <h2>Form</h2>
        <form action="/crud/CRUD.php" method="POST">
            <div class="form-group">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required>

            </div>
            <div class="form-group">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>

            <button type="submit" class="btn btn-primary mt-3 mb-3">Submit</button>

        </form>
        <!-- from end  -->
        <hr>
        <!-- Data table start  -->
        <table class="table" id="mytable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
      $sql = "select * from user";
      $result = mysqli_query($conn,$sql);
      $sno=1;
      while($row=mysqli_fetch_assoc($result)){ //data fetch loop
              //  print_r($row);   
              
      echo "<tr>
      <th scope='row'>$sno</th>
      <td>". $row['fname']. "</td>
      <td>". $row['lname']."</td>
      <td>
      <button type='button' class='btn btn-primary edit' id='edit". $row['sno']."'>Edit</button>
      <button type='button' class='btn btn-danger delete' id='delete". $row['sno']."'>Delete</button>
      </td>
    </tr>";
    $sno++;
     }
    //  <a href='/crud/CRUD.php?edit=". $row['sno']. "' class='btn btn-primary' name='edit' id='edit'>Edit</a>  <a href='/crud/CRUD.php?delete=". $row['sno']. "'     onClick='ConfirmDelete()' class='btn btn-danger'>Delete</a>
     ?>

            </tbody>
        </table>
        <!-- data table end  -->
        <hr>
    </div>
    </div>

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!-- proper js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js">
    </script>

<!-- data table script  -->
    <script>
    $(document).ready(function() {
        $('#mytable').DataTable();
    });
    </script>

<!-- edit modal script  -->
    <script>
    $(document).ready(function() {
        $('.edit').click(function(){
            var sNo = $(this)[0].id.substr(4);
            var first_name = $(this)[0].parentNode.parentNode.getElementsByTagName("td")[0].innerText;
            var last_name =  $(this)[0].parentNode.parentNode.getElementsByTagName("td")[1].innerText;
            console.log(sNo,first_name,last_name);
            edit_sNo.value = sNo;
            edit_first_name.value = first_name; 
            edit_last_name.value = last_name; 
            $('#editModal').modal('toggle');
        });
    });
    </script>

<!-- delete modal script      -->
    <script>
    $(document).ready(function() {
        $('.delete').click(function(){
            var sNo = $(this)[0].id.substr(6);
            var first_name = $(this)[0].parentNode.parentNode.getElementsByTagName("td")[0].innerText;
            var last_name =  $(this)[0].parentNode.parentNode.getElementsByTagName("td")[1].innerText;
            console.log(sNo,first_name,last_name);
            delete_sNo.value = sNo;
            delete_first_name.value = first_name; 
            delete_last_name.value = last_name; 
            $('#deleteModal').modal('toggle');
        });
    });
    </script>

    
    <!-- <script>
    function ConfirmDelete() {
        /* var D = confirm("Are you want to delete this entry?");
        if (D == TRUE) {
            return TRUE;           
        } else {
            return FLASE;
        } */
       
        first_name = document.getElementsByTagName("td")[0].innerText;
        last_name = document.getElementsByTagName("td")[1].innerText;
        sNo = document.getElementsByClassName('delete')[0].id.substr(6);
        console.log(first_name,last_name,sNo);
        delete_first_name.value = first_name;
        delete_last_name.value = last_name;
        delete_sNo.value = sNo;
        $('#deleteModal').modal('toggle');
        
       
    }
    </script> -->
    <!-- <script>
    edits = document.getElementsByClassName('edit');
    // console.log(edits);
     Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
            // console.log(e.target.id.substr(4));
            // edit_first_name.value=document.getElementById(id).;
            // last_name=;
            $('#editModal').modal('toggle');
        });
    });
    // edits = document.getElementsByClassName('edit');
    // Array.from(edits).forEach((element) => {
    //   element.addEventListener("click", (e) => {
    //     console.log("edit ");
    //     tr = e.target.parentNode.parentNode;
    //     title = tr.getElementsByTagName("td")[0].innerText;
    //     description = tr.getElementsByTagName("td")[1].innerText;
    //     console.log(title, description);
    //     titleEdit.value = title;
    //     descriptionEdit.value = description;
    //     snoEdit.value = e.target.id;
    //     console.log(e.target.id)
    //     $('#editModal').modal('toggle');
    //   })
    // })
    </script> -->
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>