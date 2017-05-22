var countDownDate = new Date("Jul 1, 2017 8:20:25").getTime();
var x;
var cfunc = function() {
  var now = new Date().getTime();
  var distance = countDownDate - now;
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  document.getElementById("stupidHolidayCountdownRequestedByRadekDesignedByPavelAndModifiedByMarek").innerHTML = "Vysvědčení se samými jedničkami za " + days + " dní ;)";
  if (distance < 1000*60*60*24) {
    clearInterval(x);
    document.getElementById("stupidHolidayCountdownRequestedByRadekDesignedByPavelAndModifiedByMarek").innerHTML = "Prázdniny jsou tu ;)";
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
