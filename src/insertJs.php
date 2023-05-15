<html>

<body onload="menuFunction()">

  <table>
    <tr>
      <td></td>
      <td>New Device</td>
    </tr>
    <tr>
      <td>Brand</td>
      <td><select id='brand'>

        </select></td>
    </tr>
    <tr>
      <td>Type</td>
      <td><select id='type'>

        </select></td>
    </tr>
    <tr>
      <td>Serial</td>
      <td><input type="text" id="serial" value=""></td>
    </tr>
    <tr>
      <td></td>
      <td><button onClick="insertDevice()">Submit</button></td>
    </tr>
  </table>

  <table>
    <tr>
      <td></td>
      <td>New Brand</td>
    </tr>
    <tr>
      <td>Brand</td>
      <td><input type="text" id="brandHard" value=""></td>
    </tr>

    <tr>
      <td></td>
      <td><button onClick="insertBrand()">Submit</button></td>
    </tr>
  </table>



  <table>
    <tr>
      <td></td>
      <td>New Type</td>
    </tr>

    <tr>
      <td>Type</td>
      <td><input type="text" id="typeHard" value=""></td>
    </tr>

    <tr>
      <td></td>
      <td><button onClick="insertType()">Submit</button></td>
    </tr>
  </table>


  <script type="text/javascript">
    async function menuFunction() {
      let brandSelect = document.getElementById("brand");
      let typeSelect = document.getElementById("type");
      const response = await fetch("localhost//api/dropdowns");
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
        option.value = types[key];
        typeSelect.add(option);
      }
    }

    async function insertDevice() {
      let brand = document.getElementById("brand").value;
      let type = document.getElementById("type").value;
      let serial = document.getElementById("serial").value;
      const response = await fetch(`localhost/api/insertDevice?brand=${brand}&type=${type}&serial=${serial}`);
      const jsonData = await response.json();
      console.log(jsonData);
    }



  </script>
</body>

</html>