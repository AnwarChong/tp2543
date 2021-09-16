<?php
include_once 'orders_details_crud.php';

if (!isset($_SESSION['loggedin']))
    header("LOCATION: login.php");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
 <title>Luxurious Time Piece Collection(Swiss Edition) Orders</title>
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
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $conn->prepare("SELECT * FROM tbl_order_a177016_pt2, tbl_staff_a177016_pt2,
        tbl_customer_a177016_pt2 WHERE
        tbl_order_a177016_pt2.FLD_STAFF_ID = tbl_staff_a177016_pt2.FLD_STAFF_ID AND
        tbl_order_a177016_pt2.FLD_CUSTOMER_ID = tbl_customer_a177016_pt2.FLD_CUSTOMER_ID AND
        FLD_ORDER_ID = :oid");
      $stmt->bindParam(':oid', $oid, PDO::PARAM_STR);
      $oid = $_GET['oid'];
      $stmt->execute();
      $readrow = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    $conn = null;
    ?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
          <div class="panel panel-default">
            <div class="panel-heading"><strong>Order Details</strong></div>
            <div class="panel-body">
              Below are details of the order.
            </div>
            <table class="table">
              <tr>
                <td class="col-xs-4 col-sm-4 col-md-4"><strong>Order ID</strong></td>
                <td><?php echo $readrow['FLD_ORDER_ID'] ?></td>
              </tr>
              <tr>
                <td><strong>Order Date</strong></td>
                <td><?php echo $readrow['FLD_DATE_ORDERED'] ?></td>
              </tr>
              <tr>
                <td><strong>Staff</strong></td>
                <td><?php echo $readrow['FLD_STAFF_NAME']; ?></td>
              </tr>
              <tr>
                <td><strong>Customer</strong></td>
                <td><?php echo $readrow['FLD_CUSTOMER_NAME']; ?></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
          <div class="page-header">
            <h2>Add a Product</h2>
          </div>
          <form action="orders_details.php" method="post" class="form-horizontal" name="frmorder" id="forder" onsubmit="return validateForm()">
            <div class="form-group">
              <label for="prd" class="col-sm-3 control-label">Product</label>
              <div class="col-sm-9">
                <select name="pid" class="form-control" id="prd">
                  <option value="">Please select</option>
                  <?php
                  try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $conn->prepare("SELECT * FROM tbl_product_a177016_pt2");
                    $stmt->execute();
                    $result = $stmt->fetchAll();
                  }
                  catch(PDOException $e){
                    echo "Error: " . $e->getMessage();
                  }
                  foreach($result as $productrow) {
                    ?>
                    <option value="<?php echo $productrow['FLD_PRODUCT_ID']; ?>"><?php echo $productrow['FLD_BRAND']." - ".$productrow['FLD_PRODUCT_NAME']; ?></option>
                    <?php
                  }
                  $conn = null;
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="qty" class="col-sm-3 control-label">Quantity</label>
              <div class="col-sm-9">
                <input name="quantity" type="number" class="form-control" id="qty" min="1">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-9">
                <input name="oid" type="hidden" value="<?php echo $readrow['FLD_ORDER_ID'] ?>">
                <button class="btn btn-default" type="submit" name="addproduct"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Product</button>
                <button class="btn btn-default" type="reset"><span class="glyphicon glyphicon-erase" aria-hidden="true"></span> Clear</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
          <div class="page-header">
            <h2>Products in This Order</h2>
          </div>
          <table class="table table-striped table-bordered">
            <tr>
              <th>Order Detail ID</th>
              <th>Product</th>
              <th>Quantity</th>
              <th></th>
            </tr>
            <?php
            try {
              $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
              $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $stmt = $conn->prepare("SELECT * FROM tbl_order_details_a177016_pt2,
                tbl_product_a177016_pt2 WHERE
                tbl_order_details_a177016_pt2.FLD_PRODUCT_ID = tbl_product_a177016_pt2.FLD_PRODUCT_ID AND
                FLD_ORDER_ID = :oid");
              $stmt->bindParam(':oid', $oid, PDO::PARAM_STR);
              $oid = $_GET['oid'];
              $stmt->execute();
              $result = $stmt->fetchAll();
            }
            catch(PDOException $e){
              echo "Error: " . $e->getMessage();
            }
            foreach($result as $detailrow) {
              ?>
              <tr>
                <td><?php echo $detailrow['DETAILS_ORDER_ID']; ?></td>
                <td><?php echo $detailrow['FLD_PRODUCT_NAME']; ?></td>
                <td><?php echo $detailrow['FLD_ORDER_QUANTITY']; ?></td>
                <td>
                  <a href="orders_details.php?delete=<?php echo $detailrow['DETAILS_ORDER_ID']; ?>&oid=<?php echo $_GET['oid']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs" role="button">Delete</a>
                </td>
              </tr>
            <?php } ?>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
          <a href="invoice.php?oid=<?php echo $_GET['oid']; ?>" target="_blank" role="button" class="btn btn-primary btn-lg btn-block">Generate Invoice</a>
        </div>
      </div>
      <br>
    </div>

    <script type="text/javascript">

      function validateForm() {

        var x = document.forms["frmorder"]["pid"].value;
        var y = document.forms["frmorder"]["quantity"].value;
     
      if (x == null || x == "") {
        alert("Product must be selected");
        document.forms["frmorder"]["pid"].focus();
          //document.getElementById("prd").focus();
          return false;
        }
        if (y == null || y == "") {
          alert("Quantity must be filled out");
          document.forms["frmorder"]["quantity"].focus();
          //document.getElementById("qty").focus();
          return false;
        }

        return true;
      }

    </script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

  </body>
  </html>