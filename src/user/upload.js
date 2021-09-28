function getData(obj){
    let inputs = {table: []};

    for (let i = 0; i < obj.length; i++){
        let requestHeaders = {table: []};

        for (let j = 0; j < obj[i].request.headers.length; j++){
            let requestHeader = {};
            let flag = 0;

            if (obj[i].request.headers[j].name == "content-type"){
                requestHeader = {"name": obj[i].request.headers[j].name, "value": obj[i].request.headers[j].value};
                flag = 1;
            } else if (obj[i].request.headers[j].name == "cache-control"){
                requestHeader = {"name": obj[i].request.headers[j].name, "value": obj[i].request.headers[j].value};
                flag = 1;
            } else if (obj[i].request.headers[j].name == "pragma"){
                requestHeader = {"name": obj[i].request.headers[j].name, "value": obj[i].request.headers[j].value};
                flag = 1;
            } else if (obj[i].request.headers[j].name == "expires"){
                requestHeader = {"name": obj[i].request.headers[j].name, "value": obj[i].request.headers[j].value};
                flag = 1;
            } else if (obj[i].request.headers[j].name == "age"){
                requestHeader = {"name": obj[i].request.headers[j].name, "value": obj[i].request.headers[j].value};
                flag = 1;
            } else if (obj[i].request.headers[j].name == "last-modified"){
                requestHeader = {"name": obj[i].request.headers[j].name, "value": obj[i].request.headers[j].value};
                flag = 1;
            } else if (obj[i].request.headers[j].name == "host"){
                requestHeader = {"name": obj[i].request.headers[j].name, "value": obj[i].request.headers[j].value};
                flag = 1;
            }

            if (flag)
                requestHeaders.table.push(requestHeader)
        }

        let responseHeaders = {table: []};

        for (let j = 0; j < obj[i].response.headers.length; j++){
            let responseHeader = {};
            let flag = 0;

            if (obj[i].response.headers[j].name == "content-type"){
                responseHeader = {"name": obj[i].response.headers[j].name, "value": obj[i].response.headers[j].value};
                flag = 1
            } else if (obj[i].response.headers[j].name == "cache-control"){
                responseHeader = {"name": obj[i].response.headers[j].name, "value": obj[i].response.headers[j].value};
                flag = 1
            } else if (obj[i].response.headers[j].name == "pragma"){
                responseHeader = {"name": obj[i].response.headers[j].name, "value": obj[i].response.headers[j].value};
                flag = 1
            } else if (obj[i].response.headers[j].name == "expires"){
                responseHeader = {"name": obj[i].response.headers[j].name, "value": obj[i].response.headers[j].value};
                flag = 1
            } else if (obj[i].response.headers[j].name == "age"){
                responseHeader = {"name": obj[i].response.headers[j].name, "value": obj[i].response.headers[j].value};
                flag = 1
            } else if (obj[i].response.headers[j].name == "last-modified"){
                responseHeader = {"name": obj[i].response.headers[j].name, "value": obj[i].response.headers[j].value};
                flag = 1
            } else if (obj[i].response.headers[j].name == "host"){
                responseHeader = {"name": obj[i].response.headers[j].name, "value": obj[i].response.headers[j].value};
                flag = 1
            }

            if (flag)
                responseHeaders.table.push(responseHeader);
        }

        re = /(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]/;

        let input = {
            "entries": {
                "startedDateTime": obj[i].startedDateTime,
                "timings": {
                    "wait": obj[i].timings.wait
                },
                "serverIPAddress": obj[i].serverIPAddress
            },
            "request": {
                "method": obj[i].request.method,
                "url": obj[i].request.url.match(re)[0],
                "headers": requestHeaders.table
            },
            "response": {
                "status": obj[i].response.status,
                "statusText": obj[i].response.statusText,
                "headers": responseHeaders.table
            }
        }

        inputs.table.push(input);
    }

    return inputs.table;
}

function uploadData(){
    fetch("https://api.ipify.org/?format=json")
    .then(response => response.json())
    .then(data => {
        providerIP = data.ip;
        var IPs = [providerIP];

        fetch('http://ip-api.com/json/' + IPs)
        .then( response => response.json())
        .then( data => {
            serverUser.push({"serverIPAddress": data.query, "ISP": data.isp, "lat": data.lat, "lon": data.lon});
            final_data = [...serverUser, ...final_data];
        })
        .then(data => {
            final_data = [...serverIPs, ...final_data];
            console.log(final_data);
            console.log(final_data[1].length);
            final_data[1].forEach(element => {
                var serverIP = element['entries']['serverIPAddress'];
                
                fetch('https://freegeoip.app/json/' + serverIP)
                .then(response => response.json())
                .then(data => {
                    serverIPs.push({"harIPAddress": data.ip, "lat": data.latitude,"lon": data.longitude});
                    
                    if (element === final_data[1][final_data[1].length - 1]){
                        final_data = [serverIPs, final_data];
                        $.ajax({
                            url: "upload.php",
                            method: "POST",
                            data: {data : final_data},
                            success: function (res){
                                console.log(res);
                            }
                        }); 
                    }
                })
            });
        })
    })
}

function saveData(){
    save_data = final_data;
    save_data = JSON.stringify(save_data);

    const a = document.createElement('a');
    a.setAttribute('href', 'data:application/json;character=utf-8,' + encodeURIComponent(save_data));
    a.setAttribute('download', fileName + '_processed.har');
    a.click();
}

function logFile (event) {
	let str = event.target.result;
	let data = JSON.parse(str);
    data = getData(data.log.entries);
    final_data.push(data);
    console.log(final_data);
}


let final_data= [];
let serverUser= [];
let serverIPs = [];
let fileName;


$(".custom-file-input").on("change", function() {
    fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);

	// If there's no file, do nothing
	if (!this.value.length) return;

	// Create a new FileReader() object
	let reader = new FileReader();

	// Setup the callback event to run when the file is read
	reader.onload = logFile;

	// Read the file
	reader.readAsText(this.files[0]);
});

document.getElementById('upload').addEventListener('click', uploadData);
document.getElementById('save').addEventListener('click', saveData);