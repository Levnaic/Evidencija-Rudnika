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
            <label for="idRude">Vrsta rude</label>
            <select name="idRude" id="idRude">
                <option value="1">Bakar</option>
                <option value="2">Ugalj</option>
                <option value="3">Zlato</option>
                <option value="4">Srebro</option>
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