<html>

<body onload="menuFunction()">


  <label for="brand">Brand:</label><br>
  <select id='brand'>
    <option value='all' selected>All</option>
  </select>
  <br>

  <label for="type">Type:</label><br>
  <select id='type'>
    <option value='all' selected>All</option>
  </select>
  <br>

  <label for="serial">Serial Number (Optional):</label><br>
  <input type="text" id="serial" value=""><br>
  <input type="hidden" id="offset" value="0"><br>

  <button onclick="displayResults()">Search</button><br>
  <table id="resultTable">
    <thead id="resultHead"></thead>
    <tbody id="resultBody"></tbody>
  </table>



  <script type="text/javascript">
    async function menuFunction() {
      let brandSelect = document.getElementById("brand");
      let typeSelect = document.getElementById("type");
      const response = await fetch("http://localhost/api/dropdowns");
      const jsonData = await response.json();

      const brands = jsonData['data']['brands'];
      for (const key in brands) {
        let option = document.createElement("option");
        option.text = brands[key];
        option.value = key;
        brandSelect.add(option);
      }

      const types = jsonData['data']['types'];
      for (const key in types) {
        let option = document.createElement("option");
        option.text = types[key];
        option.value = key;
        typeSelect.add(option);
      }
    }

    async function displayResults() {
      //prep the request body
      let brand = document.getElementById("brand").value;
      let type = document.getElementById("type").value;
      let serial = document.getElementById("serial").value;
      let offset = document.getElementById("offset").value;

      // ships the request to the api
      const response = await fetch(`http://localhost/api/results?brand=${brand}&type=${type}&serial=${serial}`);
      const jsonData = await response.json();

      // if there are no results, do nothing
      if (jsonData.length == 0) {
        return;
      }

      // preps the table header, a specific brand or type will 
      //not have a header for that column
      let newResultHead = document.createElement('thead');
      newResultHead.setAttribute("id", "resultHead");
      let row = newResultHead.insertRow(-1);
      let cell = row.insertCell(-1);
      cell.innerText = 'id';

      if (brand === 'all') {
        cell = row.insertCell(-1);
        cell.innerText = 'brand';
      }

      if (type === 'all') {
        cell = row.insertCell(-1);
        cell.innerText = 'type';
      }

      cell = row.insertCell(-1);
      cell.innerText = 'serial';

      let oldResultHead = document.getElementById("resultHead");
      let ResultHead = oldResultHead.parentNode;
      ResultHead.replaceChild(newResultHead, oldResultHead);



      let newResultTable = document.createElement('tbody');
      newResultTable.setAttribute("id", "resultBody");
      const results = jsonData['data']['results'];
      for (const key in results) {
        let row = newResultTable.insertRow(-1);
        let cell = row.insertCell(-1);
        cell.innerText = results[key]['id'];

        if (brand === 'all') {
          cell = row.insertCell(-1);
          cell.innerText = results[key]['brand'];
        }

        if (type === 'all') {
          cell = row.insertCell(-1);
          cell.innerText = results[key]['type'];
        }

        cell = row.insertCell(-1);
        cell.innerText = results[key]['serial'];

        cell = row.insertCell(-1);
        cell.innerHTML = 
          `<button onclick=modify({results[key]})">Modify</button>`;
      }

      let oldResultTable = document.getElementById("resultBody");
      let ResultTable = oldResultTable.parentNode;
      ResultTable.replaceChild(newResultTable, oldResultTable);
    }


  </script>
</body>

</html>