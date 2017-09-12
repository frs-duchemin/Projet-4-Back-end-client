


jQuery(function($){
	$.datepicker.regional['fr'] = {
		closeText: 'Fermer',
		prevText: '&#x3c;Préc',
		nextText: 'Suiv&#x3e;',
		currentText: 'Aujourd\'hui',
		monthNames: ['Janvier','Fevrier','Mars','Avril','Mai','Juin',
		'Juillet','Aout','Septembre','Octobre','Novembre','Decembre'],
		monthNamesShort: ['Jan','Fev','Mar','Avr','Mai','Jun',
		'Jul','Aou','Sep','Oct','Nov','Dec'],
		dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
		dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
		dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: '',
		minDate: 0,
		maxDate: '+12M +0D',
		numberOfMonths: 1,
		showButtonPanel: true
		};
	$.datepicker.setDefaults($.datepicker.regional['fr']);
});

function DisableSunday(date) {
 
        var day = date.getDay();
           if (day == 0) {
              return [false] ;
           } else {
             return [true] ;
 }
  }

function IsNoel(date) {
    var day = date.getDate();
    var month = date.getMonth() + 1;
    return (day === 25 && month === 12 );
}

function IsJourAn(date) {
    var day = date.getDate();
    var month = date.getMonth() + 1;
    return (day === 1 && month === 1 );
}
function IsTravail(date) {
    var day = date.getDate();
    var month = date.getMonth() + 1;
    return (day === 1 && month === 5 );
}
function IsFete(date) {
    var day = date.getDate();
    var month = date.getMonth() + 1;
    return (day === 14 && month === 7 );
}

function IsToussaint(date) {
    var day = date.getDate();
    var month = date.getMonth() + 1;
    return (day === 1 && month === 11 );
}
function IsAssomption(date) {
    var day = date.getDate();
    var month = date.getMonth() + 1;
    return (day === 15 && month === 8 );
}

 $(function() {
 $( "#frs_louvrebundle_commande_dateVisite" ).datepicker({
 beforeShowDay: DisableSunday && function (date) {
     return [(!IsJourAn(date)
     &&!IsTravail(date)
     &&!IsFete(date)
     && !IsAssomption(date)
     &&!IsToussaint(date)
     &&!IsNoel(date))];
 }
 });

 });

  $( function() {
    $( "#frs_louvrebundle_commande_dateVisite" ).datepicker( $.datepicker.regional[ "fr" ] );
     } );

