<?php

  // Load the wrapper class.
  require 'Session.php';

  // Create helper function.
  function session($keys = null)
  {
    return new Session($keys, '.');
  }

  // Helper for example.
  function pp($content)
  {
    echo '<pre>';
    print_r($content);
    echo '</pre>';
  }

?>
<!doctype html>
<html>

<head>
  <title>Example Site For Session Wrapper Class</title>
  <style>h4 { padding: 20px 0 0 0; border-top: 1px solid gray; }</style>
</head>
<body>

  <?php

    // Reset sessions for new loading.
    session()->destroy();

    // Show empty $_SESSION:
    echo '<h4>Empty session:</h4>';
    pp(session()->get());

    // Create new Session:
    session('Stark')->set('Winter Is Coming');

    // Show $_SESSION with just created key/value:
    echo '<h4>Session with new value:</h4>';
    pp(session()->get());

    // Get a session.
    echo '<h4>Get a session by key:</h4>';
    echo session('Stark')->get();

    // Add nested session:
    session('who.knows.nothing')->set('Jon Snow');

    // Show $_SESSION with just created nested key/value:
    echo '<h4>Add nested session:</h4>';
    pp(session()->get());

    // Remove key from nested session ('nothing' will be deleted):
    session('who.knows.nothing')->remove();
    // or session('who.knows.nothing')->delete();

    // Show $_SESSION with without 'nothing':
    echo '<h4>Show session with deleted key:</h4>';
    pp(session()->get());

    // Check if value exists:
    echo '<h4>Check if "Stark" exists:</h4>';
    pp(session('Stark')->exists());

    // Compare two values:
    echo '<h4>Compare if value from "Stark" is "A Lannister always pays his debts"</h4>';
    if(session('Stark')->is('A Lannister always pays his debts')) {
      echo "yep";
    } else {
      echo "nope";
    }

  ?>

</body>
</html>