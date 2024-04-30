<!DOCTYPE html>
<html>
<head>
    <title>BroadcastOps Interface</title>
    <style>
        body {
            background-image: url('');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            padding-top: 50px; /* Adjust top padding if necessary */
            margin: 0; /* Reset any default margins */
            box-sizing: border-box;   
        }
        table {
            margin: 20px auto; /* Center the table */
            width: auto; /* Let the table size according to its content */
            max-width: 80%; /* Maximum width of the table */
            border-collapse: collapse; /* Collapse borders */
            background: #212121; /* Table background */
            box-shadow: 0 0 30px rgba(0,0,0,0.5); /* Shadow for depth */
            color: #fff; /* Text color */
            table-layout: fixed; /* Fixed layout can help make the table more uniform */
            border-radius: 8px; /* This adds rounded corners to the table */
            overflow: hidden; /* Ensures the content doesn't spill outside the border-radius */
        }
        th, td {
            border: 1px solid #303030; /* Cell border */
            padding: 8px; /* Cell padding, adjust as needed */
            text-align: center; /* Center text */
            white-space: nowrap; /* Prevent text wrapping */
            overflow: hidden; /* Hide overflow */
            text-overflow: ellipsis; /* Add ellipsis to text overflow */
            height: 1.2em; /* Adjust height as needed */
            line-height: 1.2em; /* Line height to match cell height */
        }
        th {
            background-color: #424242;
            font-weight: bold;
        }
        .status-block {
            display: inline-block;
            width: 20px;
            height: 20px;
            cursor: pointer;
            vertical-align: middle; /* Align the block to the top of the cell */
        }
        .offline {
            background-color: #e74c3c;
        }
        .online {
            background-color: #2ecc71;
        }
        .reboot-icon {
            display: inline-block;
            vertical-align: middle;
            width: 20px;
            height: 20px;
            margin: 0 auto; /* Center the icon horizontally */
        }
        /* Styles to handle the text under the icons */
        .credentials {
            text-align: center;
            display: block; /* Use block to ensure it takes its own line */
            font-size: 0.8em; /* Adjust size as necessary */
        }
        .location-cell {
            background-color: #424242; /* Dark grey background */
            color: #fff; /* White text */
        }
        table, th, td {
            border: 1px solid #303030;
        }
        .credentials .password {
            text-decoration: none;
            color: transparent;
        }
        .credentials:hover .password {
            color: #fff;
        }
        .page-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-start;
            gap: 20px; /* Adjust the gap between the elements as needed */
            padding: 20px; /* Space from the window edges */
        }
        .iframe-container {
            display: flex;
            flex-direction: column;
            gap: 20px; /* Space between iframes */
        }
        iframe {
            width: 700px; /* Iframe width */
            height: 394px; /* Iframe height */
            border: 1px solid #303030; /* Iframe border, optional */
            background: #fff; /* Iframe background, to ensure visibility */
        }
    </style>
</head>
<body>
    <div class="page-container">
        <!-- Iframe container on the left -->
        <div class="iframe-container">
            <iframe src="source_here"></iframe> 
            <iframe src="source_here"></iframe>
            <iframe src="source_here"></iframe>
        </div>
    <div>
        <table id="result">
            <tr>
                <th>Location</th>
                <th>Camera Status</th>
                <th>Remote Status</th>
                <th>Access Point</th>
                <th>Decoder Status</th>
                <th>Camera Reboot</th>
                <th>Decoder Reboot</th>
            </tr>
            <!-- Rows will be inserted here by JavaScript -->
        </table>
    </div>

    <div class="iframe-container">
            <iframe src="source_here"></iframe>
            <iframe src="source_here"></iframe>
            <iframe src="source_here"></iframe>
        </div>
    </div>

    <script>
        // Define cameras with their corresponding IP addresses and remote IPs
        const cameras = [
            {       
                name: '1',
                ip: 'ip_here',
                user: 'user',
                pass: 'pass',
                remoteIp: ' ',
                remoteUser: ' ',
                remotePass: ' ',
                apIp: ' ',
                apUser: ' ',
                apPass: ' ',
                decoderIp: '123.123.123.123',
                decoderUser: 'user',
                decoderPass: 'pass',
                cameraRebootIP: '123.123.123.123',
                cameraRebootUser: 'user',
                cameraRebootPass: 'password',
                decoderRebootIP: '',
                decoderRebootUser: '',
                decoderRebootPass: ''
            },
            {       
                name: '2',
                ip: 'ip_here',
                user: 'user',
                pass: 'pass',
                remoteIp: ' ',
                remoteUser: ' ',
                remotePass: ' ',
                apIp: ' ',
                apUser: ' ',
                apPass: ' ',
                decoderIp: '123.123.123.123',
                decoderUser: 'user',
                decoderPass: 'pass',
                cameraRebootIP: '123.123.123.123',
                cameraRebootUser: 'user',
                cameraRebootPass: 'password',
                decoderRebootIP: '',
                decoderRebootUser: '',
                decoderRebootPass: ''
            },
            {       
                name: '3',
                ip: 'ip_here',
                user: 'user',
                pass: 'pass',
                remoteIp: ' ',
                remoteUser: ' ',
                remotePass: ' ',
                apIp: ' ',
                apUser: ' ',
                apPass: ' ',
                decoderIp: '123.123.123.123',
                decoderUser: 'user',
                decoderPass: 'pass',
                cameraRebootIP: '123.123.123.123',
                cameraRebootUser: 'user',
                cameraRebootPass: 'password',
                decoderRebootIP: '',
                decoderRebootUser: '',
                decoderRebootPass: ''
            }
            // ... (add all cameras here with their main and remote IPs)
        ];

            // Function to create a reboot cell with power icon and credentials
            function createRebootCell(rebootUser, rebootPass, rebootIP) {
                const rebootCellContainer = document.createElement('div');
                rebootCellContainer.className = 'status-block-container';


                if (rebootUser && rebootPass) {
                    const link = document.createElement('a');
                    link.href = `http://${rebootIP}`; // Link to the IP address
                    link.target = '_blank';

                    const icon = document.createElement('img');
                    icon.src = 'power.png';
                    icon.className = 'reboot-icon';
                    link.appendChild(icon); // Append the icon to the link
                    rebootCellContainer.appendChild(link); // Append the link to the container

                
                    const usernameDiv = document.createElement('div');
                    usernameDiv.className = 'credentials';
                    usernameDiv.textContent = `U: ${rebootUser} `; // Notice the space after the username
                    rebootCellContainer.appendChild(usernameDiv);

                    // Create div for the password
                    const passwordDiv = document.createElement('div');
                    passwordDiv.className = 'credentials';
                    passwordDiv.innerHTML = `P: <span class="password">${rebootPass}</span>`;
                    rebootCellContainer.appendChild(passwordDiv); // Append passwordDiv to the container

                }

                return rebootCellContainer;
            }

            function createCredentialsCell(user, pass) {
                const credentialsDiv = document.createElement('div');
                credentialsDiv.className = 'credentials';
                credentialsDiv.innerHTML = `U: ${user} <br> P: <span class="password">${pass}</span>`;
                return credentialsDiv;
            }

            window.onload = function() {
            const table = document.getElementById("result");
            cameras.forEach(camera => {
                const row = table.insertRow();
                

                // Create the 'Location' cell with a special class
                const locationCell = row.insertCell();
                locationCell.textContent = camera.name;
                locationCell.className = 'location-cell'; // Add this line to set the class name
                

                // Camera IP cell with status block and credentials
                const cameraIpCell = row.insertCell();
                const cameraStatusBlockContainer = document.createElement('div');
                cameraStatusBlockContainer.className = 'status-block-container';

                const cameraLink = document.createElement('a');
                cameraLink.href = `http://${camera.ip}`;
                cameraLink.target = '_blank';

                const cameraStatusBlock = document.createElement('div');
                cameraStatusBlock.id = `${camera.ip}-status`;
                cameraStatusBlock.className = 'status-block offline';
                cameraLink.appendChild(cameraStatusBlock); // Append status block to the link
                cameraStatusBlockContainer.appendChild(cameraLink); // Append link to the container

                // Use createCredentialsCell for username and hidden password
                const cameraCredentialsDiv = createCredentialsCell(camera.user, camera.pass);
                cameraStatusBlockContainer.appendChild(cameraCredentialsDiv);

                cameraIpCell.appendChild(cameraStatusBlockContainer);

                // Remote IP cell with status block and credentials
                const remoteIpCell = row.insertCell();
                if(camera.remoteIp.trim() !== '') {
                    const remoteStatusBlockContainer = document.createElement('div');
                    remoteStatusBlockContainer.className = 'status-block-container';

                    const remoteLink = document.createElement('a');
                    remoteLink.href = `http://${camera.remoteIp}`;
                    remoteLink.target = '_blank';

                    const remoteStatusBlock = document.createElement('div');
                    remoteStatusBlock.id = `${camera.remoteIp}-status`;
                    remoteStatusBlock.className = 'status-block offline';
                    remoteLink.appendChild(remoteStatusBlock); // Append status block to the link
                    remoteStatusBlockContainer.appendChild(remoteLink); // Append link to the container

                    // Use createCredentialsCell for username and hidden password
                    const remoteCredentialsDiv = createCredentialsCell(camera.remoteUser, camera.remotePass);
                    remoteStatusBlockContainer.appendChild(remoteCredentialsDiv);

                    remoteIpCell.appendChild(remoteStatusBlockContainer);
                }

                // Access Point IP cell with status block and credentials
                const apIpCell = row.insertCell();
                if(camera.apIp.trim() !== '') {
                    const apStatusBlockContainer = document.createElement('div');
                    apStatusBlockContainer.className = 'status-block-container';

                    const apLink = document.createElement('a');
                    apLink.href = `http://${camera.apIp}`;
                    apLink.target = '_blank';

                    const apStatusBlock = document.createElement('div');
                    apStatusBlock.id = `${camera.apIp}-status`;
                    apStatusBlock.className = 'status-block offline';
                    apLink.appendChild(apStatusBlock); // Append status block to the link
                    apStatusBlockContainer.appendChild(apLink); // Append link to the container

                    // Use createCredentialsCell for username and hidden password
                    const apCredentialsDiv = createCredentialsCell(camera.apUser, camera.apPass);
                    apStatusBlockContainer.appendChild(apCredentialsDiv);

                    apIpCell.appendChild(apStatusBlockContainer);
                }

                // Decoder IP cell with status block and credentials
                const decoderIpCell = row.insertCell();
                if(camera.decoderIp.trim() !== '') {
                    const decoderStatusBlockContainer = document.createElement('div');
                    decoderStatusBlockContainer.className = 'status-block-container';

                    const decoderLink = document.createElement('a');
                    decoderLink.href = `http://${camera.decoderIp}`;
                    decoderLink.target = '_blank';

                    const decoderStatusBlock = document.createElement('div');
                    decoderStatusBlock.id = `${camera.decoderIp}-status`;
                    decoderStatusBlock.className = 'status-block offline';
                    decoderLink.appendChild(decoderStatusBlock); // Append status block to the link
                    decoderStatusBlockContainer.appendChild(decoderLink); // Append link to the container
  
  
                    // Use createCredentialsCell for username and hidden password
                    const decoderCredentialsDiv = createCredentialsCell(camera.decoderUser, camera.decoderPass);
                    decoderStatusBlockContainer.appendChild(decoderCredentialsDiv);

                    decoderIpCell.appendChild(decoderStatusBlockContainer);
                    }

                    // Create Camera Reboot cell and append it to the row
                    const cameraRebootTd = row.insertCell();
                    const cameraRebootCell = createRebootCell(camera.cameraRebootUser, camera.cameraRebootPass, camera.cameraRebootIP);
                    cameraRebootTd.appendChild(cameraRebootCell);

                    // Create Decoder Reboot cell and append it to the row
                    const decoderRebootTd = row.insertCell();
                    const decoderRebootCell = createRebootCell(camera.decoderRebootUser, camera.decoderRebootPass, camera.decoderRebootIP);
                    decoderRebootTd.appendChild(decoderRebootCell);
            });
            pingIPs();
        }

        function updateText(ip) {
            var ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function() {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    const statusBlock = document.getElementById(ip + '-status');
                    statusBlock.className = this.responseText === "1" ? 'status-block online' : 'status-block offline';
                }
            };
            var url = 'ajax.php?domain='+ip;
            ajax.open('GET', url, true);
            ajax.send();
        }

        function pingIPs() {
            cameras.forEach(camera => {
                updateText(camera.ip);
                updateText(camera.remoteIp);
                updateText(camera.apIp);
                updateText(camera.decoderIp);
            });
        }

        setInterval(pingIPs, 5000);
    </script>
</body>
</html>