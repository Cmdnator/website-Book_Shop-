<nav class="top">
            <ul>
                <li>
                    <a href="index.php">
                        Main
                    </a>
                </li>
                <li>
                    <a href="Catalogue-page.php">
                        Catalogue
                    </a>
                </li>
                <li>
                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                        <li><a href="admin_dashboard.php">Admin Panel</a></li>
                    <?php endif; ?>
                </li>
                <li>
                    <div id="menue">
                        <a href="Aboutus-page.php">
                            More information
                        </a>
                        <div id="dropdown-menue">
                            <a class="menuelink" href="Aboutus-page.php">
                                About us
                            </a>
                            <a class="menuelink" href="FAQ-page.php">
                                FAQ
                            </a>
                            <a class="menuelink" href="Hiring-page.php">
                                Hiring
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>