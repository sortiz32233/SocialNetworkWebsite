<?php
    $ini_array = parse_ini_file("config.ini");
    $path = $ini_array['path'];
     include_once $_SERVER['DOCUMENT_ROOT'].$path.
    '/includes/helpers.inc.php';
     include_once $_SERVER['DOCUMENT_ROOT'].$path.
    '/includes/db.inc.php';

     ?>
<!DOCTYPE html>
<html>
<head>
  <?php include $_SERVER['DOCUMENT_ROOT'].$path.'/includes/notifications.html.php'; ?>
  <meta charset="UTF-8">
  <title>Profile</title>
  <script type="text/javascript">
    var recepient_id = <?php echo $userid; ?>;
  </script>
</head>
<body>
  <?php include_once $_SERVER['DOCUMENT_ROOT'].$path.'/includes/header.inc.html.php'; ?>
<link rel="stylesheet" type="text/css" href="css/newsfeed.css">

  <?php if ($_SESSION['userid'] == $userid): ?>
      <?php include $_SERVER['DOCUMENT_ROOT'] . $path.'/includes/poster.inc.html.php'; ?>
  <input type = "hidden" value="profile" name="comeFrom">
  <input type="submit" name="action" value="Posting">
  <?php
    display_posts ();
  ?>
</form>
</div>
    <form action="" method="post">
  <input id="editp" type="submit" name="action" value="edit">
  </form>

    <form  action="./index.php" method="post">
        <input id="editp" type="submit" name="action" value="showfriends">
    </form>
<?php elseif (check_friendship($pdo,$_SESSION['userid'],$userid)) :?>
<form  action="./index.php" method="post">
    <input type="hidden" name="newfriend_id" value="<?php htmlout($userid)?>">
    <input id="editp" type="submit" name="action" value="Remove Friend">
</form>
<?php elseif (check_pendingfriends($pdo,$_SESSION['userid'],$userid)) :?>
    <form  action="./index.php" method="post">
    <input type="hidden" name="newfriend_id" value="<?php htmlout($userid)?>">
    <input id="editp" type="submit" name="action" value="Cancel Request">
    </form>
<?php elseif (check_pendingfriends($pdo,$userid,$_SESSION['userid'])) :?>
    <p> Please navigate to FriendRequests so that you can accept this request (DONT BE A MEAN MOTHAFAKA)!</p>
<?php else :?>
<form  id="add-friend-form" action="./index.php" method="post">
    <input type="hidden" name="newfriend_id" value="<?php htmlout($userid)?>">
    <input id="editp" type="submit" name="action" value="Add Friend">
</form>
<?php endif; ?>

<?php
//rint_r ((array)$userinfo);
//print_r(array_values($info));
$img = $userinfo[0]['image_url'];
echo '<img height=300 width=300 src="'.$img.'">';
echo "<br>";
?>
<p id="para1"> First Name: <?php htmlout($userinfo[0]['first_name']); ?></p>
<p id="para1"> Last Name: <?php htmlout($userinfo[0]['last_name']); ?></p>
<p id="para1"> Nickname: <?php
if (!is_null($userinfo[0]['nick_name'])){
    htmlout($userinfo[0]['nick_name']);
}
else {
  htmlout('');
} ?>
</p>
<?php if (check_friendship($pdo,$_SESSION['userid'],$userid) or $_SESSION['userid'] == $userid) :?>
<p id="para2"> Birthday: <?php
if (($userinfo[0]['birth_date']) != "0000-00-00"){
    htmlout($userinfo[0]['birth_date']);
}
else {
  htmlout('');
} ?>
</p>
<?php endif ?>
<p id="para2"> Martial Status: <?php
if (!is_null($userinfo[0]['martial_status'])){
    htmlout($userinfo[0]['martial_status']);
}
else {
  htmlout('');
} ?>
</p>
<?php if (check_friendship($pdo,$_SESSION['userid'],$userid)  or $_SESSION['userid'] == $userid) :?>
<p id="para3"> About Me: <?php
if (($userinfo[0]['about_me']) != "Here you go ..."){
    htmlout($userinfo[0]['about_me']);
}
else {
  htmlout('I am NOT interesting enough');
} ?>
</p>
<?php endif; ?>
<p id="para3"> Gender : <?php htmlout($userinfo[0]['gender']); ?></p>
<p id="para3"> Home Town : <?php htmlout($userinfo[0]['home_town']); ?></p>
<?php if($_SESSION['userid'] == $userid): ?>
<?php  $myPosts = $_SESSION['myPosts'];?>
<?php if(!empty($myPosts)) :?>
  <?php for($i = 0; $i < count($myPosts); $i++): ?>
    <?php
      $fn = ($myPosts[$i]['first_name']);
      $ln = ($myPosts[$i]['last_name']);
      ?>
      <p id="para1"><?php htmlout($fn) ?> <?php htmlout($ln) ?></p>
      <?php
      $title = ($myPosts[$i]['title']);
      ?>
      <p id="para2"><?php htmlout($title)?></p>
      <?php
      $caption = ($myPosts[$i]['caption']);
      ?>
      <p id="para3"><?php htmlout($caption)?></p>
      <?php
      if (($myPosts[$i]['image_url']) != NULL){
         $image = ($myPosts[$i]['image_url']);
         echo '<img width=300 height=300 src ="'.$image.'" width=300px height=300px>';
      }
      ?>
      <?php if(in_array($myPosts[$i], $myPosts)): ?>
        <?php $post_id = $myPosts[$i]['post_id']; ?>
        <form action="" method="post">
          <div>
            <input type="hidden" value="<?php htmlout($post_id) ?>" name="postid">
            <input type = "hidden" value="profile" name="comeFrom">
            <input id="DeletePost" type="submit" name="action" value="DeletePost">
          </div>
        </form>
    <?php endif ?>
    <?php echo "<br>";
    echo "<hr>"; ?>
  <?php endfor ?>
<?php endif ?>
<?php else :?>
  <?php if(!(empty($posts))): ?>
<?php for ($i = 0; $i < count($posts); $i++): ?>
  <?php
  $title = ($posts[$i]['title']);
  ?>
  <p id="para2"><?php htmlout($title)?></p>
  <?php
  $caption = ($posts[$i]['caption']);
  ?>
  <p id="para3"><?php htmlout($caption)?></p>
  <?php
  if (($posts[$i]['image_url']) != NULL){
     $image = ($posts[$i]['image_url']);
     echo '<img width=300 height=300 src ="'.$image.'" width=300px height=300px>';
  }
  ?>
<?php endfor ?>
<?php endif ?>
<?php endif ?>
</body>
</html>
