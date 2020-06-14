<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/spsvsai.css">
  <title>Document</title>
</head>
<body>
  <form action="" method="post">
    <label for="input">Kies steen, papier of schaar</label><br>
    <input type="text" id="input" name="input" value=""><br>
    <input type="submit" value="submit" name="submit">
  </form>
  <?php
  session_start();
  if (empty($_SESSION['start'])) {
    $_SESSION['sc'] = 0;
    $_SESSION['ss'] = 0;
    $_SESSION['sp'] = 0;
    $_SESSION['pc'] = 0;
    $_SESSION['ps'] = 0;
    $_SESSION['pp'] = 0;
    $_SESSION['cc'] = 0;
    $_SESSION['cs'] = 0;
    $_SESSION['cp'] = 0;
    $_SESSION['start'] = 1;
  }
    if (isset($_POST['submit'])) {
      if ($_POST['input'] == "steen") {
        $inputworth = 1;
        $samples = array(
          '2' => 0.1/1+$_SESSION['sc'],
          '3' => 0.1/1+$_SESSION['ss'],
          '4' => 0.1/1+$_SESSION['sp'],
        );
      } else if ($_POST['input'] == "papier") {
        $inputworth = 2;
        $samples = array(
          '2' => 0.1/1+$_SESSION['pc'],
          '3' => 0.1/1+$_SESSION['ps'],
          '4' => 0.1/1+$_SESSION['pp'],
        );
      } else if ($_POST['input'] == "schaar") {
        $inputworth = 3;
        $samples = array(
          '2' => 0.1/1+$_SESSION['cc'],
          '3' => 0.1/1+$_SESSION['cs'],
          '4' => 0.1/1+$_SESSION['cp'],
        );
      } else {
        echo "dit is geen mogelijke optie!";
      }

      class Accumulator {
        function __construct($samples) {
          $this->acc = array();
          $this->ids = array();
          $this->max = 0;
            foreach($samples as $k=>$v) {
              $this->max += $v;
              array_push($this->acc, $this->max);
              array_push($this->ids, $k);
            }
          }

          function pick() {

            $random = mt_rand(0,1000)/1000 * $this->max;
              for($i=0; $i < count($this->acc); $i++) {
                 // looks through the values until we find our random number, this is our seletion
                 if( $this->acc[$i] >= $random ) {
                    return $this->ids[$i];
                 }
              }
              throw new Exception('this is mathematically impossible?');
           }

           private $max;
           private $acc;
           private $ids;
        }

        $acc = new Accumulator($samples);


        $results = array_fill_keys(array_keys($samples), 0);


        for($i=0; $i < 1; $i++) {
           $results[ $acc->pick() ]++;
        }


        foreach($results as $k=>$v) {
           if ($v == 1) {
             $botworth = $k;
           }
        }


      if ($botworth == 2) {
        echo "bot doet schaar!<br>";
      } else if ($botworth == 3) {
        echo "bot doet steen!<br>";
      } else if ($botworth == 4) {
        echo "bot doet papier!<br>";
      }

      if ($inputworth - $botworth == -1) {
        echo "Je hebt gewonnen!<br>";
        $option = $inputworth*10+$botworth;
        if ($option == 12) {
          $_SESSION['sc'] -= 0.1;
        } else if ($option == 13) {
          $_SESSION['ss'] -= 0.1;
        } else if ($option == 14) {
          $_SESSION['sp'] -= 0.1;
        } else if ($option == 22) {
          $_SESSION['pc'] -= 0.1;
        } else if ($option == 23) {
          $_SESSION['ps'] -= 0.1;
        } else if ($option == 24) {
          $_SESSION['pp'] -= 0.1;
        } else if ($option == 32) {
          $_SESSION['cc'] -= 0.1;
        } else if ($option == 33) {
          $_SESSION['cs'] -= 0.1;
        } else if ($option == 34) {
          $_SESSION['cp'] -= 0.1;
        } else {
          echo "er is iets fout gegaan";
        }
      } else if ($inputworth - $botworth == -2 OR $inputworth - $botworth == 1) {
        echo "Je hebt gelijkgespeelt probeer het nog eens.<br>";
      } else {
        echo "Je hebt verloren ik zou er alvast aan wennen.<br>";
        $option = $inputworth*10+$botworth;
        if ($option == 12) {
          $_SESSION['sc'] += 0.1;
        } else if ($option == 13) {
          $_SESSION['ss'] += 0.1;
        } else if ($option == 14) {
          $_SESSION['sp'] += 0.1;
        } else if ($option == 22) {
          $_SESSION['pc'] += 0.1;
        } else if ($option == 23) {
          $_SESSION['ps'] += 0.1;
        } else if ($option == 24) {
          $_SESSION['pp'] += 0.1;
        } else if ($option == 32) {
          $_SESSION['cc'] += 0.1;
        } else if ($option == 33) {
          $_SESSION['cs'] += 0.1;
        } else if ($option == 34) {
          $_SESSION['cp'] += 0.1;
        } else {
          echo "er is iets fout gegaan";
        }
      }
      echo "rock-scissors   ".$_SESSION['sc']."<br>";
      echo "rock-rock      ".$_SESSION['ss']."<br>";
      echo "rock-paper     ".$_SESSION['sp']."<br>";
      echo "paper-scissors  ".$_SESSION['pc']."<br>";
      echo "paper-rock     ".$_SESSION['ps']."<br>";
      echo "paper-paper    ".$_SESSION['pp']."<br>";
      echo "scissors-scissors".$_SESSION['cc']."<br>";
      echo "scissors-rock   ".$_SESSION['cs']."<br>";
      echo "scissors-paper  ".$_SESSION['cp']."<br>";
    }
  ?>
</body>
</html>
