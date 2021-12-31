<header class="header">
  <h1><a href="./">Todo App</a></h1>
  <nav class="pc-menu">
  <ul class="dropdown">
    <li><a href="https://github.com/shim369" target="_blank">Github</a></li>
    <li class="menu-single">
      <span class="more">Study</span>
      <ul class="menu-second-level">
        <li><a href="https://dotinstall.com/home" target="_blank">Dotinstall</a></li>
        <li><a href="https://leetcode.com/" target="_blank">LeetCode</a></li>
        <li><a href="https://jsprimer.net/" target="_blank">JavaScript Primer</a></li>
        <li><a href="https://prog-8.com/dashboard" target="_blank">Progate</a></li>
      </ul>
    </li>
    <?php if($result): ?>
    <li>
      <span>
        <form action="app/logout.php" method="POST">
          <input class="logout btn red" type="submit" name="logout" value="Logout">
        </form>
      </span>
    </li>
    <?php endif ?>
  </ul>
</nav>
  <div class="sp-menu">
    <span id="open-menu" class="material-icons">menu</span>
  </div> 
</header>
<div class="overlay">
  <span id="close-menu" class="material-icons">close</span>
  <nav>
    <ul>
    <?php if($result): ?>
      <li><span>User Name : <?php echo $login_user['name']; ?></span></li>
    <?php endif ?>
      <li><a href="https://github.com/shim369" target="_blank">Github</a></li>
      <li><a href="https://dotinstall.com/home" target="_blank">Dotinstall</a></li>
      <li><a href="https://leetcode.com/" target="_blank">LeetCode</a></li>
      <li><a href="https://jsprimer.net/" target="_blank">JavaScript Primer</a></li>
      <li><a href="https://prog-8.com/dashboard" target="_blank">Progate</a></li>
    <?php if($result): ?>
      <li>
        <span>
          <form action="app/logout.php" method="POST">
            <input class="logout btn red" type="submit" name="logout" value="Logout">
          </form>
        </span>
      </li>
    <?php endif ?>
    </ul>
  </nav>
</div>