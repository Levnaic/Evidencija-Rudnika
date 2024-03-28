<a href="javascript:history.back()">
    <div class="ikonicaNazad">
        <i class="fa fa-arrow-left" aria-hidden="true"></i>
    </div>
</a>
<h1>Podnesi izveštaj</h1>
<section id="formaContainer">
    <div class="formaKartica">
        <form method="POST" action="/pregled-izvestaja/podnesi-izvestaj">
            <label for="idRudnika">Izaberi rudnik</label>
            <select name="idRudnika" id="idRudnika">
                <?php foreach ($redovi as $red) : ?>
                    <option value="<?php echo $red->id; ?>"><?php echo $red->imeRudnika; ?></option>
                <?php endforeach; ?>
            </select>
            <label for="prihodi">Prihodi</label>
            <input type="number" name="prihodi" id="prihodi" data-input-type="int"></input>
            <label for="rashodi">Rashodi</label>
            <input type="number" name="rashodi" id="rashodi" data-input-type="int">
            <label for="opisIzvestaja">Opis Izvestaja</label>
            <textarea name="opisIzvestaja" rows="7" id="opisIzvestaja" data-input-type="txt"></textarea>
            <div class="formButtons">
                <button type="submit" class="formaBtn">Podnesi</button>
            </div>
        </form>
    </div>
</section>