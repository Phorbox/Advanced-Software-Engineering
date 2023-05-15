<!DOCTYPE html>
<html>

<head>
  <title>Inventory Management!</title>
  <style>
    body {
      width: 35em;
      margin: 0 auto;
      font-family: Tahoma, Verdana, Arial, sans-serif;
    }
  </style>
</head>

<body>
  <h1>api Endpoints</h1>
  <h2>Results Endpoints</h2>

  <ul>
    <li>
      <p>Search results according to specifiers, any that aren't included are assumed to search for "all" of that category </p>
      <p>/api/results?serial=abcd1234&brand=microsoft&type=projector</p>
      <table>
        <tr>
          <th>Serial</th>
          <th>Brand</th>
          <th>Type</th>
        </tr>
        <tr>
          <td>abcd1234</td>
          <td>Microsoft</td>
          <td>Projector</td>
        </tr>
      </table><br>
    </li>
    <li>
      <a href="./api/results">Show all devices</a><br>
    </li>
    <li>
      <a href="./api/results?type=projector">Show all Projectors</a><br>
    </li>
    <li>
      <a href="./api/results?brand=apple">Show all Apple devices</a><br>
    </li>
    <li>
      <a href="./api/results?serial=SN-838d0ae74d7dd5321b18f1fd0888013c">Search specific device with just serial</a><br>
    </li>
    <li>
      <a href="./api/results?serial=SN-838d0ae74d7dd5321b18f1fd0888013c&brand=microsoft&type=projector">Search specific device with all categoriess</a><br>
    </li>
  </ul>

  <h2>Dropdowns Endpoints</h2>
  <ul>
    <li>
      <p>Get all active brands and Types </p>
      <p>/api/dropdowns</p>
    </li>
    <li>
      <a href="./api/dropdowns">Show all Brands and Types</a><br>
    </li>
  </ul>

  <h2>Insert Endpoints</h2>
  <ul>
    <li>
      <p>Insert new devices, or specifiers. All fields must be filled. All of these examples have already been added, only the new device will successfully insert. </p>

    </li>
    <li>
      <a href="./api/insertType?type=Chicken Wings">Insert new type "Chicken Wings"</a><br>
      <p>/api/insertType?type=Chicken Wings</p>
      <table>
        <tr>
          <th>Type</th>
        </tr>
        <tr>
          <td>Chicken Wings</td>
        </tr>
      </table><br>
    </li>
    <li>
      <a href="./api/insertBrand?brand=gucci">Insert new Brand "Gucci"</a><br>
      <p>/api/insertBrand?brand=gucci</p>
      <table>
        <tr>
          <th>Serial</th>
          <th>Brand</th>
          <th>Type</th>
        </tr>
        <tr>
          <td>abcd1234</td>
          <td>Microsoft</td>
          <td>Projector</td>
        </tr>
      </table><br>
    </li>
    <li>
      <a href="./api/insertDevice?brand=kfc&type=Chicken%20Wings&serial=%232+with+cheese">Insert new device "#2 with cheese", a Kfc Chicken Wing</a><br>
      <p>/api/insertDevice?brand=kfc&type=Chicken%20Wings&serial=%232+with+cheese</p>
      <table>
        <tr>
          <th>Brand</th>
          <th>Type</th>
          <th>Serial</th>
        </tr>
        <tr>
          <td>kfc</td>
          <td>Chicken Wings</td>
          <td>#2 with cheese</td>
        </tr>
      </table><br>
    </li>
  </ul>
  <a href="https://www.w3schools.com/tags/ref_urlencode.ASP">w3 Schools on URL encoding</a>
</body>

</html>