<?php
  include_once 'customers_crud.php';
?>
<!DOCTYPE html>

<html><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
  <title>Luxurious Time Piece Collection(Swiss Edition) Customers</title>
 <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

  <title>Luxurious Time Piece Collection(Swiss Edition) Products</title>
  <!-- Bootstrap -->
 <link href="css/bootstrap.min.css" rel="stylesheet">


 <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
 <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
     
  </head>
  <body>
    
  <?php include_once 'nav_bar.php'; ?>

      <?php
      // Read
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM tbl_customer_a177016_pt2");
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        
      }
      catch(PDOException $e){
            echo "Error: " . $e->getMessage();
      }
      foreach($result as $readrow) {
      ?>    
        <?php $readrow['FLD_CUSTOMER_ID']; ?>
      <?php
      }
      $num = ltrim($readrow['FLD_CUSTOMER_ID'], 'C')+1;
      $num = 'C'.str_pad($num,3,"0",STR_PAD_LEFT);
     
      $conn = null;
      ?>


  <div class="container-fluid">

    <div class="row">
      <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
        <div class="page-header">
               <?php
          if (isset($_GET['edit'])) {
            echo "<h2>EDIT {$cid}</h2>";
          } else {
            echo "<h2>Create New Customer</h2>";
          }
          ?>
        </div>
       
        <form action="customers.php" method="post" class="form-horizontal">
          <div class="form-group">
            <label for="cid" class="col-sm-3 control-label">Customer ID</label>
            <div class="col-sm-9">
                <input type="text" name="cid" class="form-control" readonly value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_CUSTOMER_ID']; else echo $num?>"required/>
            </div>
          </div>

          <div class="form-group">
            <label for="cname" class="col-sm-3 control-label">Full Customer Name</label>
            <div class="col-sm-9">
              <input name="cname" type="text" class="form-control" id="cname" placeholder="First Name" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_CUSTOMER_NAME']; ?>" required />
            </div>
          </div>

          <div class="form-group">
            <label for="cphone" class="col-sm-3 control-label">Phone Number</label>
            <div class="col-sm-9">
              <input name="cphone" type="tel" class="form-control" id="cphone" placeholder="+60##-#######" pattern="[+]601[0-9]{1}-([0-9]{7}|[0-9]{8})"  value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_CUSTOMER_PHONE_NUMBER']; ?>" required />
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
              <?php if (isset($_GET['edit'])) { ?>
                <input type="hidden" name="oldcid" value="<?php echo $editrow['FLD_CUSTOMER_ID']; ?>">
                <button class="btn btn-default" type="submit" name="update"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Update</button>
              <?php } else { ?>
                <button class="btn btn-default" type="submit" name="create"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create</button>
              <?php } ?>
              <button class="btn btn-default" type="reset"><span class="glyphicon glyphicon-erase" aria-hidden="true"></span> Clear</button>
            </div>
          </div>
        </form>
      </div>
       </div>
    
    <hr/>
    <div class="row">
      <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
        <div class="page-header">
          <h2>Customer List</h2>
        </div>
        <table class="table table-striped table-bordered">
          <tr>
            <th>Customer ID</th>
            <th>Full Customer Name</th>
            <th>Phone Number</th>
            <th></th>
          </tr>
          <?php
          // Read
          $per_page = 5;
          if (isset($_GET["page"]))
            $page = $_GET["page"];
          else
            $page = 1;
          $start_from = ($page-1) * $per_page;
          try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("select * from tbl_customer_a177016_pt2 LIMIT {$start_from}, {$per_page}");
            $stmt->execute();
            $result = $stmt->fetchAll();
          }
          catch(PDOException $e){
            echo "Error: " . $e->getMessage();
          }
          foreach($result as $readrow) {
            ?>   
            <tr>
              <td><?php echo $readrow['FLD_CUSTOMER_ID']; ?></td>
              <td><?php echo $readrow['FLD_CUSTOMER_NAME']; ?></td>
              <td><?php echo $readrow['FLD_CUSTOMER_PHONE_NUMBER']; ?></td>
              <td>
                <a href="customers.php?edit=<?php echo $readrow['FLD_CUSTOMER_ID']; ?>" class="btn btn-success btn-xs" role="button"> Edit </a>
                <a href="customers.php?delete=<?php echo $readrow['FLD_CUSTOMER_ID']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs" role="button">Delete</a>
              </td>
            </tr>
          <?php } ?>

        </table>
      </div>
    </div>

     <div class="row">
      <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
        <nav>
          <ul class="pagination">
            <?php
            try {
              $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
              $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $stmt = $conn->prepare("SELECT * FROM tbl_customer_a177016_pt2");
              $stmt->execute();
              $result = $stmt->fetchAll();
              $total_records = count($result);
            }
            catch(PDOException $e){
              echo "Error: " . $e->getMessage();
            }
            $total_pages = ceil($total_records / $per_page);
            ?>
            <?php if ($page==1) { ?>
              <li class="disabled"><span aria-hidden="true">&laquo</span></li>
            <?php } else { ?>
              <li><a href="customers.php?page=<?php echo $page-1 ?>" aria-label="Previous"><span aria-hidden="true">&laquo</span></a></li>
              <?php
            }
            for ($i=1; $i<=$total_pages; $i++)
              if ($i == $page)
                echo "<li class=\"active\"><a href=\"customers.php?page=$i\">$i</a></li>";
              else
                echo "<li><a href=\"customers.php?page=$i\">$i</a></li>";
              ?>
              <?php if ($page==$total_pages) { ?>
                <li class="disabled"><span aria-hidden="true">&raquo</span></li>
              <?php } else { ?>
                <li><a href="customers.php?page=<?php echo $page+1 ?>" aria-label="Previous"><span aria-hidden="true">&raquo</span></a></li>
              <?php } ?>
            </ul>
          </nav>
        </div>
      </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
  </html>