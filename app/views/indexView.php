<section id="naslovIndex" class="margine">
    <h1>Aktivni rudnici</h1>
</section>

<section class="margine dodajNovi">
    <a href="#" class="dodajNoviLink">
        <i class="fa fa-print fa-2x" aria-hidden="true"></i>
        <p>Štampaj podatke o rudnicima</p>
    </a>
</section>

<section class="tabela margine">
    <table>
        <!-- filteri -->
        <tr>
            <th class="pretraga">
                <form action="" method="GET">
                    <input type="text" name="poljePretrage" placeholder="pretraga po naslovu" value="<?php if (isset($_GET['poljePretrage'])) {
                                                                                                            echo $_GET['poljePretrage'];
                                                                                                        } ?>" placeholder="Pretraga po nazivu">
                    <button type="submit" class="filterDugme">Pretraži</button>
                </form>
            </th>
        </tr>
        <!-- nazivi kolona -->
        <tr>
            <th>Naziv rudnika</th>
            <th>Vrsta rude</th>
            <th>Prihodi</th>
            <th>Rashodi</th>
            <th>Profit</th>
        </tr>
        <!-- polja -->
        <?php foreach ($redovi as $red) : ?>
            <tr>
                <td><?php echo $red->imeRudnika; ?></td>
                <td><?php echo $red->vrstaRude; ?></td>
                <td><?php echo $red->prihodi; ?></td>
                <td><?php echo $red->rashodi; ?></td>
                <td><?php echo $red->profit; ?></td>

            </tr>
        <?php endforeach; ?>
    </table>
</section>