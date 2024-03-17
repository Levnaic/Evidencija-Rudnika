<a href="javascript:history.back()">
    <div class="ikonicaNazad">
        <i class="fa fa-arrow-left" aria-hidden="true"></i>
    </div>
</a>
<h1>Dodaj Rudnik</h1>
<section id="formaContainer">
    <div class="formaKartica">
        <form method="POST" action="/kontrola-rudnika/dodaj-rudnik">
            <label for="imeRudnika">Ime rudnika</label>
            <input type="text" name="imeRudnika" id="imeRudnika" data-input-type="txt">
            <label for="vrstaRude">Vrsta rude</label>
            <select name="vrstaRude" id="vrstaRude">
                <option value="bakar">Bakar</option>
                <option value="ugalj">Ugalj</option>
                <option value="zlato">Zlato</option>
                <option value="srebro">Srebro</option>
            </select>
            <div class="checkBoxContainer">
                <input type="checkbox" name="imaDozvolu" data-input-type="bool" id="imaDozvolu">
                <label for="imaDozvolu">Ima dozvolu?</label>
            </div>
            <div class="formButtons">
                <button type="submit" class="formaBtn">Dodaj</button>
            </div>
        </form>
    </div>
</section>