
const examTemplate = '\
  <td class="exam-cell">\
    <a href="#delete-exam" class="link-delete trigger" data-id="$ID$" style="display: none;"></a>\
    <span class="link-exam">\
      <div class="exam-item">\
        <span class="exam-subject">$SUBJECT$</span>\
        <span class="exam-range">$RANGE$</span>\
        <span class="exam-date">$DATE$</span><span class="exam-author">$AUTHOR$</span>\
      </div>\
    </span>\
  </td>\
'

function showExams(data) {
  var table = document.getElementById('exams-table');

  // Remove all existing workbooks
  while (table.firstChild) {
    table.removeChild(table.firstChild);
  }

  data.exams.forEach((exam) => {
    var subject = exam.subject;
    if('group' in exam) {
      subject += ' <span class="exam-group">' + exam.group + '</span>';
    }

    var examText = (examTemplate
      .replace('$SUBJECT$', subject)
      .replace('$RANGE$', exam.range)
      .replace('$DATE$', exam.date)
      .replace('$AUTHOR$', exam.author));

    var tr = document.createElement('tr');
    tr.innerHTML = examText;

    table.appendChild(tr);
  });
}

function loadExams() {
  loadJSON('/exams.json?v=4', showExams);
}
