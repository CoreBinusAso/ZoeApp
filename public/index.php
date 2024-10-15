<?php
// Function to create a new directory with a file on GitHub
function createGitHubDirectoryAndFile($dirName, $htmlContent, $token, $repoOwner, $repoName, $branch = 'main') {
    // Set the GitHub API URL
    $url = "https://api.github.com/repos/$repoOwner/$repoName/contents/publics/$dirName/index.html";

    // Encode the HTML content in Base64
    $base64Content = base64_encode($htmlContent);

    // Data to send to GitHub API
    $data = json_encode([
        'message' => "Create $dirName/index.html",
        'content' => $base64Content,
        'branch' => $branch
    ]);

    // HTTP headers for GitHub API
    $headers = [
        "Authorization: token $token",
        "User-Agent: $repoOwner",
        "Content-Type: application/json"
    ];

    // Initialize cURL session
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    // Execute cURL request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Handle the response from GitHub
    if ($httpCode == 201) {
        echo "Directory '$dirName' with index.html created successfully.";
    } else {
        echo "Failed to create directory '$dirName'. Response: $response";
    }
}

// GitHub Personal Access Token (replace this with a secure environment variable or secure storage)
$githubToken = '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'; // Replace with your regenerated token

// GitHub repository information
$repoOwner = 'CoreBinusAso';
$repoName = 'ZoeApp';

// Check if "dir" parameter is passed (e.g., index.php?dir=kirai2)
if (isset($_GET['dir'])) {
    $dirName = $_GET['dir'];  // Directory name from URL parameter
    
    // HTML content with Firebase integration and table structure
    $htmlContent = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ZoeApp</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid black;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
        </style>
        <script src="https://www.gstatic.com/firebasejs/9.22.1/firebase-app-compat.js"></script>
        <script src="https://www.gstatic.com/firebasejs/9.22.1/firebase-database-compat.js"></script>
        
        <script>
          // Firebase configuration
          const firebaseConfig = {
            apiKey: "AIzaSyC2Gh0QTmawv5GXJR_EygmrYpxYLgwc4X8",
            authDomain: "zoeapp-fdf06.firebaseapp.com",
            databaseURL: "https://zoeapp-fdf06-default-rtdb.firebaseio.com",
            projectId: "zoeapp-fdf06",
            storageBucket: "zoeapp-fdf06.appspot.com",
            messagingSenderId: "302798178167",
            appId: "1:302798178167:web:14612f87faa0dd15934372"
          };
          // Initialize Firebase
          const app = firebase.initializeApp(firebaseConfig);
          const database = firebase.database(app);

          // Function to fetch data from Firebase Realtime Database
          function fetchData() {
            const ref = database.ref("/");
            ref.on("value", (snapshot) => {
              const data = snapshot.val();
              console.log(data);  // Log data to console
              displayData(data);  // Display data in HTML
            });
          }

          // Function to display data in HTML
          function displayData(data) {
            const tableBody = document.getElementById("data-table-body");
            tableBody.innerHTML = ""; // Clear existing data
            for (const bucketID in data) {
              const bucketData = data[bucketID];
              for (const year in bucketData) {
                for (const month in bucketData[year]) {
                  for (const day in bucketData[year][month]) {
                    const rowData = bucketData[year][month][day];
                    const row = `<tr>
                                  <td>${bucketID}</td>
                                  <td>${year}-${month}-${day}</td>
                                  <td>${rowData.donatur || "Tidak Ada"}</td>
                                  <td>${rowData.tinggi || "Tidak Ada"}</td>
                                  <td><a href="${rowData.foto || "#"}" target="_blank">Lihat Gambar</a></td>
                                </tr>`;
                    tableBody.innerHTML += row;  // Add row to table
                  }
                }
              }
            }
          }

          window.onload = fetchData;
        </script>
    </head>
    <body>
        <header>
            <h1>Data Tanaman ZoeApp</h1>
        </header>
        <main>
            <h2>List Data Tanaman</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID Pohon</th>
                        <th>Tanggal</th>
                        <th>Donatur</th>
                        <th>Tinggi</th>
                        <th>Foto</th>
                    </tr>
                </thead>
                <tbody id="data-table-body">
                </tbody>
            </table>
        </main>
        <footer>
            <p>&copy; 2024 ZoeApp</p>
        </footer>
    </body>
    </html>
    ';

    // Create the directory and file on GitHub
    createGitHubDirectoryAndFile($dirName, $htmlContent, $githubToken, $repoOwner, $repoName);
} else {
    echo 'Please provide a directory name in the URL. For example, index.php?dir=kirai2';
}
?>
