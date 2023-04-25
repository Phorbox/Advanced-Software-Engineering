<html>

<body onload="menuFunction()">
  <form method='post' action='resultsApi.php'>

    <label for="brand">Brand:</label><br>
    <select id='brand'>
      <option value='all' selected>All</option>
    </select>
    </br>

    <label for="type">Type:</label><br>
    <select id='type'>
      <option value='all' selected>All</option>
    </select>
    </br>

    <label for="serial">Serial Number (Optional):</label><br>
    <input type="text" name="serial" value=""><br>
    <input type="hidden" name="offset" value="0"><br>

    <button type='submit' name='submit' value='submit'>Submit</button>
    <button onclick="displayResults()"></button>
  </form>


  <script type="text/javascript">
    async function menuFunction() {
      let brandSelect = document.getElementById("brand");
      let typeSelect = document.getElementById("type");
      const response = await fetch("http://localhost/api/dropdowns.php");
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
      let brand = document.getElementById("brand").value;
      let type = document.getElementById("type").value;
      let serial = document.getElementById("serial").value;
      const response = await fetch(`http://localhost/api/resultsQuery.php?brand=${brand}&type=${type}&serial=${serial}`);
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
  </script>
</body>

</html>