
// This is our template. Every time we want to create a new WB element, we
// copy this string and replace occurences of $PLACEHOLDER$ with actual values 
const wbTemplate = '<td><a href="$LINK$"><div class="link"><span class="link-text">$NAME$</span></div><div class="subject-icon" style="background-image: url(\'$ICON$\')"></div></a><a href="$ARCHIVE$"><div class="link-archive"><span class="link-archive-text">Archiv</span></div></a></td>';

function showWorkbooks(data) {
  // Get reference to the table outside the loop
  var table = document.getElementById('workbooks-table');
  
  // Remove all existing workbooks
  while (table.firstChild) {
    table.removeChild(table.firstChild);
  }

  // Iterate over all workbooks
  data.forEach(function(wb) {
    // Replace placeholders with actual values
    var wbText = (wbTemplate
      .replace('$LINK$', wb.url)
      .replace('$NAME$', wb.name)
      .replace('$ICON$', wb.icon)
      .replace('$ARCHIVE$', wb.archive));

    // Prepare <tr> containing our WB
    var tr = document.createElement('tr');
    tr.innerHTML = wbText;

    // Insert the new element into the table
    table.appendChild(tr);
  });
}

function loadWorkbooks() {
  // Schedule workbooks download
  // Also pray our implementation of loadJSON works
  loadJSON('/workbooks.json', showWorkbooks);
}
