/**
 * Created by dima on 4/21/16.
 */

/**
 * Charge User Balance
 */
function chargeBalance() {
    var $amountCharger = $('#amountCharger'),
        $amountPlaceholder= $('.currentAmount'),
        selectedAmount = $('.amount:checked').val(),
        currentAmount = $amountPlaceholder.attr('data-amount');

    if (selectedAmount !== currentAmount) {
        $.ajax({
            method: "POST",
            url: '/chargeUserAmount',
            data: {
                'amount': selectedAmount,
                '_token': $('input[name=_token]').val()
            }
        }).done(function(data) {
            if (data['status']) {
                $amountPlaceholder.html(data['total_amount']);
                $amountCharger.modal('hide');
            }
        });
    }
}