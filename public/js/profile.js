/**
 * POST XHR to Charge User Balance
 */
function chargeBalance() {
    var $amountCharger = $('#amountCharger'),
        $amountPlaceholder= $('.currentAmount'),
        selectedAmount = $('.amount:checked').val(),
        currentAmount = $amountPlaceholder.attr('data-amount');

    if (selectedAmount !== currentAmount) {
        $.ajax({
            method: "POST",
            url: '/chargeAmount',
            data: {
                'amount': selectedAmount,
                '_token': $('input[name=_token]').val()
            }
        }).done(function(data) {
            if (data['status']) {
                updateBalance(data['total_amount']);
                $amountCharger.modal('hide');
            }
        });
    }
}

/**
 * Update Balance
 * @param balance
 */
function updateBalance(balance) {
    $('.currentAmount').html(balance);
}

// Enable pusher logging - don't include this in production
Pusher.log = function(message) {
    if (window.console && window.console.log) {
        window.console.log(message);
    }
};

var pusher = new Pusher('e95c6a7f2c5eed28e4a1', {
    encrypted: true
});

var channel = pusher.subscribe('UserChargedBalance');

channel.bind('AffiliateProgram\\Events\\UserChargedBalance', function(data) {
    if (data['payment']['total_amount']) {
        updateBalance(data['payment']['total_amount']);
    }
});