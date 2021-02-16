<h1>Заявка на кредит</h1>
<form method="post">
    <!-- Дата открытия кредита -->
    <div class="form-group">
        <label for="datepicker">Дата открытия кредита:</label>
        <input id="datepicker" name="open_date" type="text" class="form-control" value="<?php if (isset($_POST['open_date'])) print $_POST['open_date'] ?>" required>
    </div>
    <!-- Срок кредитования -->
    <div class="form-group">
        <label for="term">Срок кредитования (1-36 мес.):</label>
        <input id="term" name="term" type="number" min="1" max="36" step="1" class="form-control" value="<?php if (isset($_POST['term'])) print $_POST['term'] ?>" required>
    </div>
    <!-- Кредитный лимит -->
    <div class="form-group">
        <label for="amount">Сумма (руб.):</label>
        <input id="amount" name="amount" type="number" min="0" class="form-control" value="<?php if (isset($_POST['amount'])) print $_POST['amount'] ?>" required>
    </div>
    <!-- Выбор типа возврата долга -->
    <div class="form-group">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payout_type" value="annuity" id="payout-type-annuity" <?php if (isset($_POST['payout_type']) && $_POST['payout_type' === 'annuity']) print 'checked' ?> >
            <label class="form-check-label" for="payout-type-annuity">Аннуитетный</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payout_type" value="different" id="payout-type-different" <?php if (isset($_POST['payout_type']) && $_POST['payout_type' === 'different']) print 'checked' ?> >
            <label class="form-check-label" for="payout-type-different">Дифференцированный</label>
        </div>
    </div>
    <input type="submit" name="submit" value="Дальше" class="btn btn-outline-success">
</form>