<a href="javascript:history.back()">
    <div class="ikonicaNazad">
        <i class="fa fa-arrow-left" aria-hidden="true"></i>
    </div>
</a>
<h1>Azuriraj izveštaj</h1>
<section id="formaContainer">
    <div class="formaKartica">
        <form method="POST" action="/pregled-izvestaja/azuriraj-izvestaj?id=<?php echo $red->id; ?>">
            <input type="hidden" name="_method" value="PATCH">
            <label for="idRudnika">Izaberi rudnik</label>
            <select name="idRudnika" id="idRudnika">
                <?php foreach ($rudnici as $rudnikLs) : ?>
                    <option value="<?php echo $rudnikLs->id; ?>" <?php echo ($rudnikLs->id === $red->idRudnika) ? "selected" : ""; ?>>
                        <?php echo $rudnikLs->imeRudnika; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="prihodi">Prihodi</label>
            <input type="number" name="prihodi" id="prihodi" data-input-type="int" <?php echo (!$red->prihodi) ? "disabled class='nedozvoljeniInput'" : "value='{$red->prihodi}'"; ?>>

            <label for="rashodi">Rashodi</label>
            <input type="number" name="rashodi" id="rashodi" data-input-type="int" <?php echo (!$red->rashodi) ? "disabled class='nedozvoljeniInput'" : "value='{$red->rashodi}'"; ?>>

            <label for="opisIzvestaja">Opis Izvestaja</label>
            <textarea name="opisIzvestaja" rows="7" id="opisIzvestaja" data-input-type="txt"><?php echo $red->opisIzvestaja; ?></textarea>
            <div class="formButtons">
                <button type="submit" class="formaBtn">Dodaj</button>
            </div>
        </form>
    </div>
</section>