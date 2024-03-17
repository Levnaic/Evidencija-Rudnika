<h1>Kontrola Rudnika</h1>

<section class="margine dodajNovi">
    <a href="/kontrola-rudnika/dodaj-rudnik" class="dodajNoviLink">
        <i class="fa fa-plus-square fa-2x" aria-hidden="true"></i>
        <p>Dodaj novi rudnik</p>
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
            <th>Ima Dozvolu</th>
            <th>Prihodi</th>
            <th>Rashodi</th>
            <th>Profit</th>
            <th>Akcije</th>
        </tr>
        <!-- polja -->
        <?php foreach ($redovi as $red) : ?>
            <tr>
                <td><?php echo $red->imeRudnika; ?></td>
                <td><?php echo $red->vrstaRude; ?></td>
                <td><?php echo $red->imaDozvolu; ?></td>
                <td><?php echo $red->prihodi; ?></td>
                <td><?php echo $red->rashodi; ?></td>
                <td><?php echo $red->profit; ?></td>
                <td class="usersTableBtns">
                    <div class="tableBtnsContainer">
                        <a href="/kontrola-rudnika/azuriraj-rudnik?id=<?php echo $red->id; ?>" class="adminAction firstActionBtn">Ažuriraj</a>
                        <form action="/kontrola-rudnika/obrisi-rudnik?id=<?php echo $red->id; ?>" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="adminAction">Obriši</button>
                        </form>
                    </div>
                </td>

            </tr>
        <?php endforeach; ?>
    </table>
</section>