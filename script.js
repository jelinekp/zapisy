var countDownDate = new Date("Jun 29, 2018 8:00:00").getTime();
var x;
var motd;
var cfunc = function() {
  var now = new Date().getTime();
  var distance = countDownDate - now;
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  document.getElementById("stupidHolidayCountdownRequestedByRadekDesignedByPavelModifiedByMarekAndMaintainedByTheSamePavelWhoDesignedItThatIsGoingToBeAddedToTheMobileAppWhenAndroidStudioStopsTellingMeThereIsNonexistentDependencyInTheProject-BtwThisAlsoCompletelyBreaksNanoSoIHaveToUseGedit").innerHTML = motd.start + days + motd.end;
  if (distance < 1000*60*60*24) {
    clearInterval(x);
    document.getElementById("stupidHolidayCountdownRequestedByRadekDesignedByPavelModifiedByMarekAndMaintainedByTheSamePavelWhoDesignedItThatIsGoingToBeAddedToTheMobileAppWhenAndroidStudioStopsTellingMeThereIsNonexistentDependencyInTheProject-BtwThisAlsoCompletelyBreaksNanoSoIHaveToUseGedit").innerHTML = "Vítejte ve 4.E!";
  }
}
x = setInterval(cfunc, 60 * 1000);

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        motd = JSON.parse(this.responseText);
        countDownDate = new Date(motd.date);
        cfunc();
    }
};

var zffRequest = new XMLHttpRequest();
zffRequest.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        zffData = JSON.parse(this.responseText);
        console.log(zffData);
        var zffContainer = document.getElementById("zffContainer");
        console.log(zffContainer);
        var htmlString = '<table class="zff-table">';
        for(var i = 0; i < zffData.length; i++) {
          var title = zffData[i].title.replace("/node", "https://markaos.cz/node");
          console.log(title);
          htmlString += '<tr><td class="zff-cell">' + title + "</td></tr>";
        }
        htmlString += "</table>";
        zffContainer.appendChild(document.createRange().createContextualFragment(htmlString));
    }
};

function loadZff() {
  zffRequest.open("GET", "zff.json", true);
  zffRequest.send();
}

function load() {
  xmlhttp.open("GET", "motd.json", true);
  xmlhttp.send();
  loadZff();
  $(".trigger").leanModal({closeButton: ".modal-close"});
  $(".input-date").datepicker({
    firstDay: 1,
    autoSize: true,
    dateFormat: "dd.mm.yy"
  });
  $(".link-delete").click(function(event) {
    clickId = $(event.target).data("id");
    $("#delete-exam-id").attr("value", $(event.target).data("id"));
  });
}
