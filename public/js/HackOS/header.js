async function openSoftware(software) {
    const appearance = await getSoftwareAppearance(software);
    const script = await getSoftwareScript(software);
    console.log("APPEARANCE TO LOAD : ");
    console.log(appearance);
    console.log("SCRIPT TO LOAD : ");
    console.log(script);

    const application_body = $('#application_body');
    application_body.empty();
    application_body.append(appearance);

    document.body.removeChild(document.getElementById("applicationScript"));

    /*var scriptElement = document.createElement( "script" );
    scriptElement.onload = function() {
        console.log( "Successfully loaded script using (onload)." );
    };
    scriptElement.type = "text/jsx";
    scriptElement.text = script;
    scriptElement.id = "applicationScript";
    document.body.appendChild( scriptElement );*/
    $( "<script>" )
        .on(
            "load",
            function() {
                console.log( "Successfully loaded script using (jquery + appendChild)." );
            }
        )
        .prop( "type", "text/jsx" )
        .prop( "text", script )
        .prop( "id", "applicationScript" )
        .each(
            function() {
                document.body.appendChild( this );
            }
        )
    ;
}

async function getSoftwareAppearance( software ) {
    const appearance = await getDataByAPI('?ajax=true&page=softwares&action=getSoftware&softwareName=' + software);
    return appearance;
}

async function getSoftwareScript( software ) {
    const script = await getDataByAPI('?ajax=true&page=softwares&action=getScript&softwareName=' + software);
    return script;
}

async function getDataByAPI(url) {
    return new Promise(resolve => {
        fetch(url)
        .then(async response => {
            const data = await response.text();

            // check for error response
            if (!response.ok) {
                // get error message from body or default to response statusText
                return Promise.reject(error);
            }
            resolve(data);

        })
        .catch(error => {
            console.error('There was an error!', error);
        });
    });
}