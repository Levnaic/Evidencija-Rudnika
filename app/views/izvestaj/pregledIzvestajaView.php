<h1>Pregled izveštaja</h1>
<?php if ($uloga === "knjigovodja") { ?>
    <section class="margine dodajNovi">
        <a href="/pregled-izvestaja/podnesi-izvestaj" class="dodajNoviLink">
            <i class="fa fa-plus-square fa-2x" aria-hidden="true"></i>
            <p>Podnesi izveštaj</p>
        </a>
    </section>
<?php } ?>

<section class="tabela margine">
    <table>
        <!-- filteri -->
        <tr>
            <th class="prazanTh"></th>
            <th class="prazanTh"></th>
            <th class="prazanTh"></th>
            <th class="prazanTh"></th>
            <?php if ($uloga === "knjigovodja") {
                echo "<th class='prazanTh'></th>";
            } else {  ?>
                <th class="pretraga">
                    <form action="" method="GET">
                        <input type="text" name="poljePretrage" placeholder="pretraga po podnesiocu" value="<?php if (isset($_GET['poljePretrage'])) {
                                                                                                                echo $_GET['poljePretrage'];
                                                                                                            } ?>" placeholder="Pretraga po nazivu">
                        <button type="submit" class="filterDugme">Pretraži</button>
                    </form>
                </th>
            <?php } ?>
        </tr>
        <!-- nazivi kolona -->
        <tr>
            <th>Naziv rudnika</th>
            <th>Datum</th>
            <th>Prihodi</th>
            <th>Rashodi</th>
            <th>Podnesilac</th>
            <th>Akcije</th>
        </tr>
        <!-- polja -->
        <?php foreach ($redovi as $red) : ?>
            <tr>
                <td><?php echo $red->imeRudnika; ?></td>
                <td><?php echo $red->datum; ?></td>
                <td><?php echo $red->prihodi; ?></td>
                <td><?php echo $red->rashodi; ?></td>
                <td><?php echo $red->podnesilac; ?></td>
                <td class="usersTableBtns">
                    <div class="tableBtnsContainer">
                        <a href="/pregled-izvestaja/azuriraj-izvestaj?id=<?php echo $red->id; ?>" class="adminAction firstActionBtn">Ažuriraj</a>
                        <form action="/pregled-izvestaja/obrisi-izvestaj?id=<?php echo $red->id; ?>" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="adminAction">Obriši</button>
                        </form>
                    </div>
                </td>

            </tr>
        <?php endforeach; ?>
    </table>
</section>