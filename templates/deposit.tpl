<h1>Заявка на вклад</h1>
<form method="post">
    <!-- Дата открытия вклада -->
    <div class="form-group">
        <label for="datepicker">Дата открытия вклада:</label>
        <input id="datepicker" name="open_date" type="text" class="form-control" value="<?php if (isset($_POST['open_date'])) print $_POST['open_date'] ?>" required>
    </div>
    <!-- Срок вклада -->
    <div class="form-group">
        <label for="term">Срок вклада:</label>
        <select id="term" name="term" class="form-select" aria-label="deposit-term">
            <option selected>Выберите срок вклада</option>
            <option value="90">31-90 дней</option>
            <option value="180">91-180 дней</option>
            <option value="270">181-270 дней</option>
            <option value="365">271-365 дней</option>
            <option value="546">366-546 дней</option>
            <option value="730">547-730 дней</option>
        </select>
    </div>
    <!-- Выбор способа выплаты процентов -->
    <div class="form-group">
        <div class="form-group-header">Выплата процентов:</div>
        <div class="form-check">
            <label class="form-check-label" for="reinvest-monthly">Ежемесячная капитализация</label>
            <input id="reinvest-monthly" class="form-check-input" type="radio" name="reinvest" value="monthly" <?php if (isset($_POST['reinvest'])) if ($_POST['reinvest'] === 'monthly') print 'checked' ?> >
        </div>
        <div class="form-check">
            <label class="form-check-label" for="reinvest-at-end">В конце срока</label>
            <input id="reinvest-at-end" class="form-check-input" type="radio" name="reinvest" value="at_end" <?php if (isset($_POST['reinvest'])) if ($_POST['reinvest'] === 'at_end') print 'checked' ?> >
        </div>
    </div>
    <input type="submit" name="submit" value="Дальше" class="btn btn-outline-success">
</form>
