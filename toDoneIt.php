<!DOCTYPE html>
<html>
<head>

  <title>To Done It</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="author" content="John Petrou"/>
  <meta name="description" content="To Dont it"/>
  <meta http-equiv="Expires" content="-1">
  <link rel="stylesheet" type="text/css" href="toDoneIt.css">

</head>

<body>

  <!-- Get data -->
  <?php

    // eonnect to db
    $host = "127.0.0.1";
    $user = "root";
    $password = "root";
    $database = "tododb";
    $cxn = mysqli_connect($host, $user, $password, $database);

    // check operation
    if($_POST["submitBTN"] == "Add")
    {

        // build insert statement
        $sql = "insert into todotable (item_no, description) values ('" .
          $_POST["itemNumber"] . "', '" . $_POST["itemDescription"] . "');";
        $result = mysqli_query($cxn, $sql);

        // error handling
        if($result == false)
        {
          $message = "<h3>ADD operation failed!</h3>" .
            "<h4>ADD command error: " . $sql . "</h4>" .
            "<h4>SQL Error: " . mysqli_error($cxn) . "</h4>";
        }
        else
        {
          $message = "<h3>ADD operation succeeded!</h3>";
        }

    } // check operation
    else if($_POST["submitBTN"] == "Delete")
    {

        // build delete statment
        $sql = "delete from todotable where item_no = '" . $_POST["item_entry"] . "';";
        $result = mysqli_query($cxn, $sql);

        // error handling
        if($result == false)
        {
          $message = "<h3>DELETE operation failed!</h3>" .
            "<h4>DELETE command error: " . $sql . "</h4>" .
            "<h4>SQL Error: " . mysqli_error($cxn) . "</h4>";
        }
        else
        {
          $message = "<h3>DELETE operation succeeded!</h3>";
        }

    }
    else // no operation
    {
      $message = "NO operation.</h3>";
    }

    // populate table
    $sql = "select item_no, description from todotable;";
    $result = mysqli_query($cxn, $sql);

  ?>


  <!-- table -->
  <h2>To Done List</h2>

  <div class="center">

  <table style="border:2px; width:100%">
    <colgroup>
      <col width="20%">
      <col width="80%">
    </colgroup>
    <thead>
      <tr>
        <td>
          <b>To Do Item</b>
        </td>
        <td>
          <b>Description</b>
        </td>
      </tr>
    </thead>
    <tbody>
      <!-- retrieve data to build table -->
      <?php
        // error handling
        if($result == false)
        {
          echo "<tr><td colspan='3'>SQL error: no data available!</td></tr>";
        }
        else
        {
          echo "<tr>";
          while($row = mysqli_fetch_row($result))
          {
            echo "<td>$row[0]</td>";
            echo "<td>$row[1]</td>";
            echo "</tr>";
          }
        }
      ?>

    <tbody>
  </table>
</div>

  <h2>To Do Command Center</h2>

  <div class="center">

  <form
    method="post"
    enctype="application/x-www-form-urlencoded"
    action="http://127.0.1/toDoneIt.php"
    >

    <!-- Add item_entry -->
    <div class="center">
    <fieldset>


      <legend>Needs to be done</legend>
      <input type="radio" name="submitBTN" value="Add">
      <span>Add</span>
      <br><br>

      <label>Item Number:</label>
      <input type="text" name="itemNumber">

      <label>Description:</label>
      <input type="text" name="itemDescription">

    </fieldset>

    <!-- Delete item_entry -->
    <fieldset>
      <legend>Has been done</legend>
      <input type="radio" name="submitBTN" value="Delete">
      <span>Delete</span>
      <br><br>

      <label>Item Number Completed:</label>
      <input type="text" name="item_entry">
    </fieldset>
  </div>

  <div class="center">
      <br>
      <input type="submit" value="Submit">
      <input type="reset" value="Reset" >
    </div>
  </form>
</div>

  <!-- Show result -->
  <?php
    // echo "<div style="padding-left: 29%;
    // padding-right: 25%;">";
    // echo $message;
    // echo "</div>";

    echo $message;
  ?>

</body>
</html>
