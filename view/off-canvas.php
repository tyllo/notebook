
<div class="off-canvas-wrap" data-offcanvas>
  <div class="inner-wrap">
    <nav class="tab-bar show-for-small">
      <section class="left">
        <?php include ('modal.html');?>
      </section>
      <section class="middle tab-bar-section">
        <h1 class="title">Блокнот</h1>
      </section>
      <section class="right-small">
        <a class="right-off-canvas-toggle menu-icon" ><span></span></a>
      </section>
    </nav>
    <aside class="right-off-canvas-menu">
        <ul class="off-canvas-list">
        <li><label>Users</label></li>
        <li><a href="#">Hari Seldon</a></li>
        <li class="has-submenu">
          <a href="#">R. Giskard Reventlov</a>
          <ul class="right-submenu">
            <li class="back"><a href="#">Back</a></li>
            <li><label>Level 1</label></li>
            <li><a href="#">Link 1</a></li>
            <li class="has-submenu">
              <a href="#">Link 2 w/ submenu</a>
              <ul class="right-submenu">
                <li class="back"><a href="#">Back</a></li>
                <li><label>Level 2</label></li>
                <li><a href="#">...</a></li>
              </ul>
            </li>
            <li><a href="#">...</a></li>
          </ul>
        </li>
        <li><a href="#">...</a></li>
        </ul>
    </aside>
    <section class="main-section">
    <!-- content goes here -->
    <?php include ('content.php'); ?>
    </section>
    <a class="exit-off-canvas"></a>
  </div>
</div>
