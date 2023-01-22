let treqTripForm = function(context) {
    let jq = {
        travelerType: function() {
            return $('#js-trip-form input[name="traveler_type"]:checked').val();
        },
        travelerOther: function() {
            return $('#js-traveler-other');
        },
        travelerUWORG: function() {
            return $('#js-traveler-uworg');
        },
        personalTimeChecked: function() {
            return $('#js-trip-form input[name="personal_time"]:checked').length > 0;
        },
        personalTimeDates: function() {
            return $('#js-personal-time-dates');
        },
        personalTimeDatesInput: function() {
            return $('input[name="personal_time_dates"]');
        },
        honorarium: function() {
            return $('#js-honorarium');
        },
        honorariumChecked: function() {
            return $('#js-trip-form input[name="has_honorarium"]:checked').length > 0;
        },
        honorariumAmount: function() {
            return $('#js-honorarium-amount');
        },
    };

    let honorariumChanged = function() {
        if (jq.honorariumChecked()) {
            jq.honorariumAmount().show();
        } else {
            jq.honorariumAmount().hide();
        }
    };

    let personalTimeChanged = function() {
        if (jq.personalTimeChecked()) {
            jq.personalTimeDatesInput().prop('required',true);
            jq.personalTimeDates().show();
        } else {
            jq.personalTimeDatesInput().prop('required',false);
            jq.personalTimeDates().hide();
        }
    };

    let travelerTypeChanged = function() {
        let type = jq.travelerType();
        if (type === 'uworg') {
            jq.travelerOther().hide();
            jq.travelerUWORG().show();
        } else {
            jq.travelerUWORG().hide();
            jq.travelerOther().show();
        }
        if (type === 'non_uw') {
            jq.honorarium().show();
        } else {
            jq.honorarium().hide();
        }
    };

    if (context.length === 0) {
        return;
    }

    honorariumChanged();
    personalTimeChanged();
    travelerTypeChanged();
    context.find('input[name="has_honorarium"]').on('change', honorariumChanged);
    context.find('input[name="personal_time"]').on('change', personalTimeChanged);
    context.find('input[name="traveler_type"]').on('change', travelerTypeChanged);
};

$( document ).ready(function(){
    treqTripForm($('#js-trip-form'));
});
