var countDownDate = new Date("Jun 29, 2018 8:00:00").getTime();
var x;
var cfunc = function() {
  var now = new Date().getTime();
  var distance = countDownDate - now;
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  document.getElementById("stupidHolidayCountdownRequestedByRadekDesignedByPavelAndModifiedByMarek").innerHTML = "Letní prázdniny už za " + days + " dní ;)";
  if (distance < 1000*60*60*24) {
    clearInterval(x);
    document.getElementById("stupidHolidayCountdownRequestedByRadekDesignedByPavelAndModifiedByMarek").innerHTML = "Vítejte ve 4.E!";
  }
}
x = setInterval(cfunc, 60 * 1000);

function load() {
  cfunc();
  $(".trigger").leanModal({closeButton: ".modal-close"});
  $(".input-date").datepicker({
    firstDay: 1,
    autoSize: true,
    dateFormat: "dd.mm.yy"
  });
  $(".link-delete").click(function(event) {
    clickId = $(event.target).data("id");
    $("#delete-exam-id").attr("value", $(event.target).data("id"));
    //window.location = window.location + "/delete.php?id=" + $(event.target).data("id");
  });
}
