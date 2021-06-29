<?php require 'lib/shared.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>The Mime Files [Upload]</title>
  <meta name="description" content="Upload more Mime images!" />
</head>
<body>
  <header><h1>The Mime Files</h1></header>
  <nav>
    <a href="index.php">The Mime Files</a>
    <a href="upload.php">Upload</a>
  </nav>
  <main>
    <div>
      <p>Upload a mime image!</p>
      <?php require 'lib/upload.php'; ?>
      <form enctype="multipart/form-data" method="post">
        <table>
          <tbody>
            <tr>
              <td>
                <input type="file" name="mimefile" />
              </td>
            </tr>
            <tr>
              <td>
                <input type="submit" name="upload" value="upload" />
              </td>
            </tr>
          </tbody>
        </table>
      </form>
    </div>
  </main>
  <footer>&copy; 2021 - The Mime Files</footer>
</body>
</html>
