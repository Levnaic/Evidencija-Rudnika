<a href="javascript:history.back()">
    <div class="ikonicaNazad">
        <i class="fa fa-arrow-left" aria-hidden="true"></i>
    </div>
</a>
<h1>Ažuriraj rudnik</h1>
<section id="formaContainer">
    <div class="formaKartica">
        <form method="POST" action="/kontrola-rudnika/azuriraj-rudnik?id=<?php echo $red->id; ?>">
            <input type="hidden" name="_method" value="PATCH">
            <label for="imeRudnika">Ime rudnika</label>
            <input type="text" name="imeRudnika" id="imeRudnika" data-input-type="txt" value="<?php echo $red->imeRudnika; ?>">
            <label for="vrstaRude">Vrsta rude</label>
            <select name="vrstaRude" id="vrstaRude">
                <option value="1" <?php echo ($red->vrstaRude === 'bakar') ? 'selected' : ''; ?>>Bakar</option>
                <option value="2" <?php echo ($red->vrstaRude === 'ugalj') ? 'selected' : ''; ?>>Ugalj</option>
                <option value="3" <?php echo ($red->vrstaRude === 'zlato') ? 'selected' : ''; ?>>Zlato</option>
                <option value="4" <?php echo ($red->vrstaRude === 'srebro') ? 'selected' : ''; ?>>Srebro</option>
            </select>
            <div class="checkBoxContainer">
                <input type="checkbox" name="imaDozvolu" data-input-type="bool" id="imaDozvolu" <?php if ($red->imaDozvolu) {
                                                                                                    echo "checked";
                                                                                                } ?>>
                <label for="imaDozvolu">Ima dozvolu?</label>
            </div>
            <div class="formButtons">
                <button type="submit" class="formaBtn">Dodaj</button>
            </div>
        </form>
    </div>
</section>