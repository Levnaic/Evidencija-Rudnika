<nav>
    <div class="linkovi">
        <a href="/" class="animacijaPodvlacenje">Aktivni rudnici</a>
        <?php
        if (isset($_SESSION['uloga'])) {
            echo "<a href='/pregled-izvestaja'>Pregled izveštaja</a>";
        }
        ?>
        <?php
        if (isset($_SESSION['uloga']) && $_SESSION['uloga'] === "admin") {
            echo "<a href='/kontrola-rudnika'>Kontrola rudnika</a>";
        }
        ?>
    </div>
    <div class="korisnik">
        <i id="korisnikIkonica" class="fa fa-user fa-3x" aria-hidden="true"></i>
        <div class="padajuciMeni">
            <?php
            if (isset($_SESSION['korisnickoIme'])) { ?>
                <p>Ime: <?php echo $_SESSION['korisnickoIme']; ?></p>
                <p>Uloga: <?php echo $_SESSION['uloga']; ?></p>
                <a href="/odjava" class="standardBtn">Odjava</a>
            <?php } else { ?>
                <a href="/prijava" class="standardBtn">Prijava</a>
                <a href="/registracija" class="standardBtn">Registracija</a>
            <?php } ?>
        </div>
    </div>

</nav>