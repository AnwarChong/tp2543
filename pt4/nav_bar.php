<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
  
      <a class="navbar-brand" href="index.php">Luxurious Time Piece Collection</a>

    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    
      <form class="navbar-form navbar-left" action="search.php" method="post">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="search Products" name="inputsearch"required >
        </div>
        <button type="submit" name="search"class="btn btn-default">Submit</button>
      </form>
          <ul class="nav navbar-nav navbar-center"><li><a href="Game/index.php" style="background-color: #000;"><?php echo $_SESSION['user']['FLD_STAFF_ROLE']; ?></a></li></ul>
      <ul class="nav navbar-nav navbar-right">
        
         <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
          aria-expanded="false" style="color:white;"><?php echo $_SESSION['user']['FLD_STAFF_NAME']; ?> <span
          class="caret"></span></a>
          <ul class="dropdown-menu" style="background-color: #181717;">
            <li><a href="logout.php" style="color:white;">Log out</a></li>
          </ul>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Menu <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="products.php">Products</a></li>
            <li><a href="customers.php">Customers</a></li>
            <li><a href="staffs.php">Staff</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="orders.php">Orders</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>