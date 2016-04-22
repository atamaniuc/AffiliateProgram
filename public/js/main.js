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
            var response = JSON.parse(data);

            if (response.status) {
                var zeroString = currentAmount.indexOf('.') > -1 ? '.00' : '';
                $amountPlaceholder.html(parseFloat(currentAmount) + parseFloat(selectedAmount) + zeroString);
                $amountCharger.modal('hide');
            }
        });
    }
}